<?php
/**
 * トップページ用の暫定的実装である。
 * ページリソースを呼び出せるようにリファクタリングしていく。
 * ページリソースとしての動作と、コントローラーとしての動作の両方を実装する。
 */

namespace NpApp\Controller\App;

use Flower\Form\FormUtils;
use NpApp\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractController
{
    protected $header = 'お問い合わせ';

    protected $pane = 'base/app_4_8';

    protected $sidebarTemplate = 'snipets/navigation/skiplinks';
    protected $sidebarProperties = array(
            'collection' => array(
                array(
                    'href' => '#i/form',//hrefがなくても、target指定のみでskipLink自体は動きます。
                    'target' => 'i/form',
                    'label' => '問い合わせフォーム',
                    'ng-show' => '!currentScope.result && !currentScope.fail',
                ),
                array(
                    'href' => '#i/mail',
                    'target' => 'i/mail',
                    'label' => 'メールによる問い合わせ',
                    'ng-show' => '!currentScope.result && !currentScope.fail',
                ),
                array(
                    'href' => '#i/tel',
                    'target' => 'i/tel',
                    'label' => 'お電話によるお問い合わせ',
                ),
                array(
                    'href' => '#i/address',
                    'target' => 'i/address',
                    'label' => '問い合わせ先住所',
                ),
            ),
        );

    protected $subnaviProperties = array(
        'content' =>
'
<p class="danger alert" ng-show="sharedVars.message.error">{{sharedVars.message.error}}</p>
<p class="success alert" ng-show="sharedVars.message.success">{{sharedVars.message.success}}</p>
<p class="info alert" ng-show="sharedVars.message.info">{{sharedVars.message.info}}</p>
',
    );
    /**
     * アプリケーションページの作成用コントローラー
     * 実際には、ng-viewを返すだけか。
     *
     */
    public function indexAction()
    {
    }

}