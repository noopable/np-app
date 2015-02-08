<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\App;

use NpApp\Controller\AbstractController;
use Zend\Json\Json;
use Zend\Stdlib\ArrayUtils;
use Zend\Validator\EmailAddress as EmailAddressValidator;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


/**
 *
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class UserController extends AbstractController
{
    protected $header = 'アカウントサービス';

    protected $sidebarTemplate = '/app/user/sidebar';

    protected $sidebarProperties = array(
        'collection' => array(
            'index' => array(
                'href' => '/app/user#/index',
                'label' => 'サービスインデックス',
                'ng-class' => '{active: activePath==\'/index\'}',
            ),
            'create' => array(
                'href' => '/app/user#/create',
                'label' => 'アカウント登録',
                'ng-class' => '{active: activePath==\'/create\'}',
                'ng-show' => '!isLoggedIn()',
            ),
            'activation' => array(
                'href' => "/app/user#/activation",
                'label' => 'アクティベーション',
                'ng-class' => '{active: activePath==\'/activation\'}',
                'ng-show' => 'isLoggedIn() && !isActiveUser()',
            ),
            'edit' => array(
                'href' => '/app/user#/edit',
                'label' => '個人情報の編集',
                'ng-class' => '{active: activePath==\'/edit\'}',
                'ng-show' => 'isActiveUser()',
            ),
            'signin' => array(
                'href' => '/app/user#/signin',
                'label' => 'サインイン/サインアウト',
                'ng-class' => '{active: activePath==\'/signin\'}',
            ),
        )
    );

    protected $subnaviProperties = array(
        'content' =>
'
<p class="danger alert" ng-show="sharedVars.message.error">{{sharedVars.message.error}}</p>
<p class="success alert" ng-show="sharedVars.message.success">{{sharedVars.message.success}}</p>
<p class="info alert" ng-show="sharedVars.message.info">{{sharedVars.message.info}}</p>
',
    );

    public function indexAction()
    {
    }

    public function editAction()
    {
        $params = array(
            'controller' => 'user',
            'action' => 'index',
        );
        $url = $this->url()->fromRoute('app', $params) . '#/edit';
        return $this->redirect()->toUrl($url);
    }

    /**
     * appでは、createActionのページを提示するのみで、実際には何も操作しない
     * サイドバーのactive判定をAngularJS側で実装したら、URLからactionを取り除く
     * $locationの値で判定すればいいと思うよ。
     * FOLK3i3i3
     */
    public function createAction()
    {
        $params = array(
            'controller' => 'user',
            'action' => 'index',
        );
        $url = $this->url()->fromRoute('app', $params) . '#/create';
        return $this->redirect()->toUrl($url);
    }

    /**
     * メールリンク等から アクティベーション リクエストがあった場合の処理
     * 基本的にリダイレクトされる。
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function activateAction()
    {
        $fm = $this->flashMessenger();
        $params = $this->params()->fromRoute();
        if (! isset($params['localpart'])) {
            $params =  Json::decode($this->getRequest()->getContent(), Json::TYPE_OBJECT);
            if (! isset($params['localpart'])) {
                $jsonModel = new JsonModel(array('result' => false, 'message' => 'パラメーターが不足しています'));
                $jsonModel->setTerminal(true);
                return $jsonModel;
            }
        }
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

        if (isset($hasMessage)) {
            $params = array(
                'controller' => 'user',
                'action' => 'index',
            );
            $url = $this->url()->fromRoute('app', $params) . '#message/activate';
            return $this->redirect()->toUrl($url);
        }
    }

    public function registerAction()
    {
        //登録希望メールアドレスとパスワードを受け取る。
        //パスワードを設定していないときは、自動育成する
        //確認メールを送り、確認を待つステータスにする
    }

    public function updateAction()
    {

    }

    public function deleteAction()
    {

    }

    /**
     * サインインフォームを出力するためのアクション
     * 実際のサインインはAPIに対して行う。
     */
    public function signinAction()
    {
        $params = array(
            'controller' => 'user',
            'action' => 'index',
        );
        $url = $this->url()->fromRoute('app', $params) . '#/signin';
        return $this->redirect()->toUrl($url);
    }

    public function signoutAction()
    {

    }
}
