<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\Api;

use Flower\Person\Identical\EmailInterface;
use NpApp\Model\Contact;
use Zend\Http\Response;
use Zend\Mail\Message;
use Zend\View\Model\JsonModel;

/**
 * Description of ContactController
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class ContactController extends AbstractApiController
{

    public function postAction()
    {
        $accessControl = $this->getAccessControlService();
        $service = $this->getService('Contact');
        $data = $this->getJsonRequest(true);
        $response = array('request' => $data);
        $createFromDb = false;
        $dbResult = false;
        $mailResult = false;

        $res = $service->createContact();
        if ($res['result']) {
            $contact = $res['contact'];
            $createFromDb = true;
        } else {
            $result = false;
            $dbResult = false;
            $createFromDb = false;
            //データベースエラーだが、メールだけは送信をトライするか。
            $contact = $res['contact'];
            if ($contact instanceof Contact) {
                if (!isset($contact->contact_id)) {
                    $contact->contact_id = -1;//undefined
                }
            }
            $message = $res['message'];
        }
        $posted = array_map('mb_convert_kana', $data);
        $form = new \NpApp\Form\ContactForm('f_contact');
        $form->init();
        $form->bind($contact);
        $form->setData($posted);
        if ($form->isValid()) {
            if ($accessControl->isLoggedIn()) {
                $client = $accessControl->getCurrentClientData();
                if (isset($client->primary_person_id)) {
                    $personId = $client->primary_person_id;
                    $response['person_id'] = $personId;
                    $contact->person_id = $personId;
                }
                $contact->authenticated = 1;
            }
            //これでpersonをsave
            if ($createFromDb) {
                $res = $service->save($contact);
                //保存されたデータを取り出して挿入済みデータに間違いがないか確認
                $contact = $service->getContact($contact->contact_id);

                $dbResult = $result = isset($res['result']) ? $res['result'] : false;
                $message = isset($res['message']) ? $res['message'] : '';
            }

            $response['contact'] = $contact->getArrayCopy(true);
            //このデータでメールを送信する。
            try {
                /**
                 * @todo 実プロジェクトのサービスからメール送信を行うようにする。
                 * 
                 */
                $this->sendContactMail($contact);
                if ($dbResult) {
                    $message = 'データベースに登録し、お問い合わせを送信しました';
                } else {
                    $message = 'お問い合わせを送信しました';
                }
                $mailResult = true;
            } catch (\Exception $ex) {
                if ($dbResult) {
                    $message = 'お問い合わせはデータベースに保存いたしましたが、';
                } else {
                    $message = '';
                }
                $message .= 'メールの送信ができませんでした。' . "\n";
                if ($dbResult) {
                    $message .= 'エラーメッセージとお問い合わせ番号[' . $contact->contact_id . ']を添えてお問い合わせください。' . "\n詳細::";
                }
                $message .= $ex->getMessage();
                $mailResult = false;
                $result = false;
            }
        } else {
            $messages = $form->getMessages();
            $message = '入力値に誤りがあります。お手数ですが修正してください。';
            $result = false;
        }
        $response['result'] = $result;
        $response['mailResult'] = $mailResult;
        $response['dbResult'] = $dbResult;
        $response['message'] = $message;
        if (isset($messages)) {
            $response['messages'] = $messages;
        }

        return $this->returnJsonTerminalModel($response);
    }

    public function replyAction()
    {

    }

    /**
     *
     * @TODO 実プロジェクトのモジュール等で必要な設定を行うようにする。
     * @param Contact $contact
     * @return type
     */
    public function sendContactMail(Contact $contact)
    {
        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $data['contact'] = $contact;
        $data['mailaddress'] = $contact->email;
        $txt = $renderer->render('mail/contact', $data);
        $smtp = $this->getServiceLocator()->get('smtp_transport');
        $txtPart = new \Zend\Mime\Part($txt);
        $txtPart->type = "text/plain";
        $body = new \Zend\Mime\Message();
        $body->setParts(array($txtPart));
        $message = new Message();
        $message->addFrom('no-reply@' . $_SERVER['SERVER_NAME'], '送信専用');
        $message->setTo("admin@example.com");
        //$message->addReplyTo("admin@example.com", "送信専用");
        $message->setSubject('[問い合わせフォーム:' . $contact->contact_id . ']' . $contact->subject);
        $message->setBody($body);
        $headers = $message->getHeaders();
        $headers->get('content-type')->setType('multipart/alternative');
        $message->setEncoding('UTF-8');
        return $smtp->send($message);
    }
}
