<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\Api;

use Flower\Person\Identical\EmailInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Mail\Message;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


/**
 * SavePersonを実行する前に、rolesなど、管理用カラムを権利なく修正できないように
 * チェックしておくこと。本人レコードから分離する方が適切な管理であるように思います。
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class UserController extends AbstractApiController
{
    protected $version = '1.0';

    /**
     * Api テスト用。受け取ったデータをそのまま返す。
     * セキュリティ上問題があるので公開サーバーではルーティングでブロックしておくこと！
     *
     * @return type
     */
    public function testAction()
    {
        $params = $this->params()->fromRoute();
        $version = $params['version'];
        $data = $this->getJsonRequest(true);
        $data['version'] = $version;
        return $this->returnJsonTerminalModel($data);
    }

    /**
     * 現在ログインしていればログインしているユーザー情報を返す
     * そうでない場合は、ログインしていないというメッセージを返す
     * これは、アプリケーション側でも必要なので、golf-comp.comのAPIにJSONPする必要はないかもしれない。
     *
     * @return type
     */
    public function meAction()
    {
        $remains = $this->params()->fromRoute('remains', false);
        $accessControl = $this->getAccessControlService();
        $res = array();
        if ($accessControl->isLoggedIn()) {
            $email = $accessControl->getIdentity();
            $res['user'] = $user = $accessControl->getCurrentClientData();
            $user->email = $email;
            $personId = $user->primary_person_id;
            switch ($remains) {
                case 'person':
                    $res['person'] = $person = $this->getService('Person')->getPerson($personId);
                    break;
            }
        } else {
            $res['message'] = 'ログインしていません';
        }
        return $this->returnJsonTerminalModel($res);

    }

    /**
     * 管理機能としては、他人の登録状況や、学校ごとの登録状況を確認する必要がある。
     * ここでは、自分の登録状況だけを確認する
     *
     * @return type
     */
    public function meSchoolAction()
    {
        $remains = $this->params()->fromRoute('remains', false);
        $repository = $this->getRepository('SchoolPerson');
        $accessControl = $this->getAccessControlService();
        if ($accessControl->isLoggedIn()) {
            $user = $accessControl->getCurrentClientData();
            $personId = $user->primary_person_id;
            switch ($remains) {
                case 'register':
                    $strategy = new \NpApp\Model\SelectStrategy\InquireSchool;
                    $strategy->setWhere(array('person_id' => $personId));
                    $collection = $repository->getCollectionWithStrategy($strategy);
                    break;
                default:
                    $collection = $repository->getCollection(array('person_id' => $personId));
                    break;
            }
            if ($collection->count() === 1) {
                return $this->returnJsonTerminalModel(array('school' => $collection->current()));
            } else {
                $schools = ArrayUtils::iteratorToArray($collection, false);
                return $this->returnJsonTerminalModel(array('schools' => $schools));
            }


        }
        return $this->returnJsonTerminalModel(array('message' => 'ログインしていません'));
    }

    public function registerSchoolAction()
    {
        $repository = $this->getRepository('SchoolPerson');
        $accessControl = $this->getAccessControlService();

        if ($accessControl->isLoggedIn()) {
            $data = $this->getJsonRequest(true);
            $email = $accessControl->getIdentity();
            $user = $accessControl->getCurrentClientData();
            $personId = $user->primary_person_id;



            $form = new \NpApp\Form\SchoolForm('f_school');
            //initしないとフィールドが追加されない。
            $form->init();
            //プロトタイプにデータを投入させる。
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $data['person_id'] = $personId;
                $reqSchoolId = $data['school_id'];
                if (array_key_exists('submit', $data)) {
                    unset($data['submit']);
                }
                $strategy = new \NpApp\Model\SelectStrategy\InquireSchool;
                $strategy->setWhere(array('person_id' => $personId));
                try {
                    $collection = $repository->getCollectionWithStrategy($strategy);
                    $personSchools = ArrayUtils::iteratorToArray($collection, false);
                    $c = count($personSchools);
                    $remove = array();
                    switch ($c) {
                        case 0:
                            $personSchool = $repository->create();
                            $data['status'] = 'person';
                            $data['memo'] = 'create record';
                            break;
                        case 1:
                            $personSchool = array_shift($personSchools);
                            if ($personSchool->school_id !== $reqSchoolId) {
                                $remove[] = (int) $personSchool->school_id;
                            }
                            break;
                        default:
                            foreach ($personSchools as $v) {
                                if ($v->school_id !== $reqSchoolId) {
                                    $remove[] = (int) $v->school_id;
                                } else {
                                    $personSchool = $v;
                                }
                            }
                            if (!isset($personSchool)) {
                                $personSchool = $repository->create();
                                $data['status'] = 'person';
                                $data['memo'] = 'reset record';
                            }
                            break;
                    }
                    if (count($remove)) {
                        $tableGateway = $repository->getTableGateway();
                        $where['person_id'] = $personId;
                        foreach ($remove as $removeSchoolId) {
                            $where['school_id'] = $removeSchoolId;
                            $tableGateway->delete($where);
                        }
                    }
                    $personSchool->exchangeArray($data);
                    $result = $repository->save($personSchool);
                } catch (\Zend\Db\Adapter\Exception\InvalidQueryException $ex) {
                    error_log($ex->getMessage());
                    $res['data'] = $data;
                    $res['message'] = '申請データが正しくない可能性があります。詳しくはお問い合わせください。' . $ex->getMessage();
                    $res['result'] = false;
                    return $this->returnJsonTerminalModel($res);
                } catch (\Exception $ex) {
                    //status 500?
                    //注意）例外メッセージをレスポンスすると、内部情報を外部にさらしてしまうことになります。
                    $res['messages'] = array(get_class($ex), $ex->getMessage());
                    $res['message'] = 'エラーが発生しました。時間を開けてお試しいただくか、お問い合わせください。';
                    $res['result'] = false;
                    return $this->returnJsonTerminalModel($res);
                }
            } else {
                $res['messages'] = $form->getMessages();
                $res['message'] = '入力値に誤りがあります。お手数ですが修正してください。';
                $res['result'] = false;
                return $this->returnJsonTerminalModel($res);
            }

            $res['data'] = $data;

            return $this->returnJsonTerminalModel($res);
        }
        return $this->returnJsonTerminalModel(array('message' => 'ログインしていません'));
    }
    /**
     * サインインしたら、XSRF-TOKENクッキーを発行してセッション（リソース）に入れる。
     * @return type
     */
    public function signinAction()
    {
        $accessControl = $this->getAccessControlService();
        $params = $this->params()->fromRoute();
        $version = $params['version'];
        $data = $this->getJsonRequest(true);
        $data['version'] = $version;
        $logExtra = array(
            'act' => 'login',
            'email' => @$data['email'],
            'ip' => $_SERVER['REMOTE_ADDR']
        );
        if (isset($data['email']) && $data['email'] && isset($data['password'])) {


            try {
                if ($accessControl->authenticate($data['email'], $data['password'])) {
                    $user = $accessControl->getCurrentClientData();
                    /**
                     * ここでPersonリポジトリからデータを取り込まないとだめか。もしくは、Emailテーブルのデータを増やすか。名前だけは増やそうか。
                     */
                    $this->log(\Zend\Log\Logger::INFO, 'Login Success', $logExtra);
                    $result = array('result' => true, 'user' => $user);
                } else {
                    $this->log(\Zend\Log\Logger::INFO, 'Login Failed', $logExtra);
                    $result = array('result' => false);
                }
            } catch (\Exception $ex) {
                //500エラーを返すように。
                $this->log(\Zend\Log\Logger::ALERT, 'Exception:' . $ex->getMessage(), $logExtra);
                $result = array('error' => 'exception occured', 'message' => $ex->getMessage());
            }
        } else {
            $this->log(\Zend\Log\Logger::ALERT, 'Login Failed:missing parameter', $logExtra);
            $result = array('result' => 'false', 'message' => '必要な情報が不足しています');
        }

        return $this->returnJsonTerminalModel($result);
    }

    public function signoutAction()
    {
        $accessControl = $this->getAccessControlService();
        $user = $accessControl->getCurrentClientData();
        $this->log(\Zend\Log\Logger::INFO, 'Logout', array('act' => 'logout', 'email' => $user->email));
        $accessControl->logout();
        $result = array('result' => true);
        return $this->returnJsonTerminalModel($result);
    }

    public function indexAction()
    {

    }

    public function showAction()
    {
        $params = $this->params();
        /**
        $service = $this->getServiceLocator()->get('')
        if (!isset($params['id'])) {
            //現在ログイン中のユーザー情報を返す
        } else {
            $
        }
         *
         */
        $data = array(
            'foo' => 'bar',
        );
        $viewModel = new JsonModel($data);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function createAction()
    {
        /** @TODO: アクセス元IPでログをとってDOS対策をする。（セッションは使えない）*/
        $data = $this->getJsonRequest(true);
        $response = array();
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $personService = $this->getService('Person');
        $accessControl = $this->getAccessControlService();
        $res = $personService->create($name, $email, $password);

        $response['result'] = $res['result'];
        if ($response['result']) {
            do {
                $personId = $res['person_id'];
                $person = $personService->getPerson($personId);
                $response['person'] = $person;
                $emails = $person ->getEmails();
                foreach ($emails as $myMail) {
                    if ($myMail->getIdentity() == $email) {
                        $response['user'] = $myMail->getArrayCopy(true);//safe
                        if ($myMail->status === 'wait') {
                            try {
                                $response['send_activation'] = $this->sendActivationMail($myMail);
                            } catch (\Exception $ex) {
                                $response['message'] = 'アカウントを登録しましたが、アクティベーションメールの送信中にエラーが発生しました。';
                                break 2;
                            }

                        }
                    }
                }
                if (! $accessControl->isLoggedIn()) {
                    $response['message'] = 'アカウントを作成しましたが、サインインはしていません';
                    $res = $accessControl->authenticate($email, $password);
                    if ($res) {
                        $response['message'] = 'アカウントを作成して認証しました。';
                    } else {
                        $response['message'] = 'アカウントを作成しましたが認証できませんでした。';
                    }
                    break;
                }
                $response['message'] = 'アカウントを作成しました。サインインできます。';
            } while (false);
        } else {
            $response['message'] = $res['message'];
        }

        $viewModel = new JsonModel($response);
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function messageAction()
    {
        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $res = array();
        $remains = $this->params()->fromRoute('remains', false);
        $version = $this->params()->fromRoute('version', '1.0');
        $data = array('version' => $version, 'remains' => $remains);
        switch ($remains) {
            case 'activate':
                $html_template = 'np-app/api/user/message/' . $remains;
                $title_template = 'np-app/api/user/message/title';
                break;
            default:
                $html_template = 'np-app/api/user/message/default';
                $title_template = 'np-app/api/user/message/title';
                break;
        }
        $res['message_html'] = $renderer->render($html_template, $data);
        $res['message_title'] = $renderer->render($title_template, $data);

        return $this->returnJsonTerminalModel($res);
    }

    /**
     * App\UserControllerとの違いは、リダイレクトしない点。
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function activateAction()
    {
        $fm = $this->flashMessenger();
        $params = $this->getJsonRequest(true);
        $hasMessage = false;
        do {
            //activation phaze
            $mailAddress = $params['localpart'] . '@' . $params['mailhost'];
            $key = $params['key'];
            $accessControl = $this->getAccessControlService();

            if ($accessControl->isLoggedIn()) {
                if ($mailAddress !== $accessControl->getIdentity()) {
                    $message = 'アクティベーションしようとしているメールアドレスと、現在サインイン中のアカウントが異なります。サインアウトしてやり直してください。';
                    $fm->addErrorMessage($message);
                    $hasMessage = true;
                    break;
                }
            }
            $personService = $this->getService('Person');
            $res = $personService->activate($mailAddress, $key);
            foreach ($res as $key => $value) {
                switch ($key) {
                    case 'result':
                        if ($value && !isset($res['success']) && !isset($res['info'])) {
                            $fm->addMessage('アクティベートしました');
                            $hasMessage = true;
                        }
                        break;
                    case 'error':
                        $fm->addErrorMessage($value);
                        $hasMessage = true;
                        break;
                    case 'info':
                        $fm->addInfoMessage($value);
                        $hasMessage = true;
                        break;
                    case 'warning':
                        $fm->addWarningMessage($value);
                        $hasMessage = true;
                        break;
                    case 'success':
                        $fm->addSuccessMessage($value);
                        $hasMessage = true;
                        break;
                    default:
                        break;
                }
            }
        } while (false);
        $res['user'] = $accessControl->getCurrentClientData();
        return $this->returnJsonTerminalModel($res);
    }

    public function updateAction()
    {
        $accessControl = $this->getAccessControlService();
        $result = false;
        $message = null;
        $user = null;
        $person = null;
        $data = null;
        do {
            if (! $accessControl->isLoggedIn()) {
                $result = false;
                $message = '先にサインインしてください';
                break;
            }
            $data = $this->getJsonRequest(true);
            if (!isset($data['user']) || !isset($data['person'])) {
                $result = false;
                $message = 'パラメーターが不足しています';
                break;
            }

            if (!is_object($data['person'])) {
                $result = false;
                $message = 'リクエストデータの型が正しくありません';
                break;
            }

            $email = $accessControl->getIdentity();
            if ($email !== $data['user']->email) {
                $result = false;
                $message = 'サインイン中のメールアドレスと一致しません';
                break;
            }

            $user = $accessControl->getCurrentClientData();
            //getCurrentClientDataは現在ログイン中のデータなので信頼してよい。
            $personId = $user->primary_person_id;
            $personService = $this->getService('Person');
            $person = $personService->getPerson($personId);
            //不要なcsrf hiddenやボタン調整のためのフィールドを除外する
            $posted = array_intersect_key(get_object_vars($data['person']), $person->getArrayCopy());

            /**
             * rolesを更新対象から除外する。
             * rolesの更新は専用のAPIを経由しgrant権限のあるユーザー(通常はadmin)だけが、
             * 自分以外のユーザーに対して自分が持っているロール(grantを除く）の与奪を可能にする。
             * 通常admin権限があれば多くの実行が可能だが、
             * grantはownerだけが実行できる。
             * ownerにはadmin権限以外にも、grant可能な権限を列挙しておく必要がある。
             * 
             * grant権限の付与はadminだけが実行できる。
             * grant権限の不正な伝播はセキュリティリスクを増大させる
             */
            if (isset($posted['roles'])) {
                unset($posted['roles']);
            }
            $posted = array_map('mb_convert_kana', $posted);
            if (isset($posted['birthday'])) {
                //Elementのフィルタに実装するべき
                $posted['birthday'] = implode('-', preg_split('/[-_年月日 .\/]/i', mb_convert_kana($posted['birthday'], 'ns')));
            }
            $form = new \NpApp\Form\PersonForm('f_person');
            //initしないとフィールドが追加されない。
            $form->init();
            //自動的に$personにデータを投入させる。
            $form->bind($person);
            $form->setData($posted);

            if ($form->isValid()) {
                //これでpersonをsave
                //todo: 入力由来のデータでstatusを変更するべきではない。
                //勝手に別のstatusを付与されてしまう可能性がある。
                $status = explode(',', $person->status);
                $status = array_combine($status, $status);
                if (isset($status['tmp'])) {
                    unset($status['tmp']);
                    $status['active'] = 'active';
                }
                $person->status = implode(',', $status);

                $emails = $person->getEmails();
                array_map(function ($email) use ($person) { $email->name = $person->name;}, $emails);

                $res = $personService->save($person);
                $result = isset($res['result']) ? $res['result'] : false;
                $message = isset($res['message']) ? $res['message'] : '';
            } else {
                $messages = $form->getMessages();
                $message = '入力値に誤りがあります。お手数ですが修正してください。';
                $result = false;
            }
            $data['person'] = $person;
        } while(false);

        $res = array(
            'result' => $result,
            'message' => $message,
            'user' => $user,
            'person' => $person,
        );
        if (isset($messages)) {
            $res['messages'] = $messages;
        }
        return $this->returnJsonTerminalModel($res);
    }

    public function deleteAction()
    {

    }

    public function updatePasswordAction()
    {
        $data = $this->getJsonRequest(true);
        $accessControl = $this->getAccessControlService();
        $adapter = $accessControl->getAuthService()->getAdapter();
        $result = false;
        $message = null;

        do {
            if (!isset($data['current']) || !isset($data['new'])) {
                $result = false;
                $message = 'パラメータが不足しています';
                break;
            }
            if (! $accessControl->isLoggedIn()) {
                $result = false;
                $message = '先にサインインしてください';
                break;
            }

            $identity = $accessControl->getIdentity();

            if ($identity !== $data['user']->email) {
                $result = false;
                $message = 'サインイン中の情報と一致しません';
                break;
            }

            $adapter->setIdentity($identity);
            $adapter->setCredential($data['current']);
            $result = $adapter->authenticate();
            if (! $result->isValid()) {
                $result = false;
                $message = '認証情報が正しくありません';
                break;
            }

            $user = $accessControl->getCurrentClientData();
            $personId = $user->primary_person_id;
            $person = $this->getService('Person')->getPerson($personId);
            $emails = $person->getEmails();
            foreach ($emails as $email) {
                if ($email->getIdentity() === $identity) {
                    $email->password = $data['new'];
                    try {
                        $this->getService('Person')->updateEmail($email);
                        $result = true;
                        $message = '更新しました。';
                    } catch (\Exception $ex) {
                        $result = false;
                        $message = $ex->getMessage();
                    }
                    break;
                }
            }
        } while (false);

        $res = array(
            'data' => $data,
            'result' => $result,
            'message' => $message,
        );
        if (isset($messages)) {
            $res['messages'] = $messages;
        }
        return $this->returnJsonTerminalModel($res);
    }

    /**
     * アクティベーションメールを送信する
     *
     */
    public function sendConfirmAction()
    {

    }

    public function sendActivationMail(EmailInterface $email)
    {
        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $data['email'] = $email;
        $data['mailaddress'] = $email->getIdentity();
        list($localpart, $mailhost) = explode('@', $data['mailaddress'], 2);
        list($key, $timestamp) = explode('/', $email->activation_code);
        //そもそもActivationcodeはここで作るべきでは？というのは次期仕様で
        $data['activationUrlParams'] = array(
            'route' => 'activate',
            'params' => array(
                'localpart' => $localpart,
                'mailhost' => $mailhost,
                'key' => $key,
            ),
        );
        $html = nl2br($renderer->render('mail/activation_html', $data));
        $txt = $renderer->render('mail/activation_txt', $data);
        $smtp = $this->getServiceLocator()->get('smtp_transport');
        $txtPart = new \Zend\Mime\Part($txt);
        $txtPart->type = "text/plain";
        $htPart = new \Zend\Mime\Part($html);
        $htPart->type = "text/html";
        $htPart->charset = "UTF-8";
        $body = new \Zend\Mime\Message();
        $body->setParts(array($txtPart, $htPart));
        //サービスに持たせた方がよい？
        $message = new Message();
        $message->addFrom('no-reply@kanto-kougoren.jp', '関東高ゴ連送信専用(返信しても受け取ることができません)');
        $message->setTo($data['mailaddress']);
        $message->addBcc("kosugi@kips.gr.jp");//バックアップ用
        $message->addReplyTo("info@golf-comp.com", "送信専用");
        $message->setSubject('アカウントアクティベーション');
        $message->setBody($body);
        $headers = $message->getHeaders();
        $headers->get('content-type')->setType('multipart/alternative');
        $message->setEncoding('UTF-8');
        return $smtp->send($message);
    }
}
