<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\App;

use NpApp\Controller\AbstractController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * トップページ等、 一般ユーザーによるアクセスパスは用意しない。
 * ただし、アカウントサービスからサイト管理ページへのセッショントークンページを育成する？
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class SiteController extends AbstractController
{
    protected $header = 'サイト管理';

    protected $sidebarTemplate = '/app/site/sidebar';

    protected $sidebarProperties = array(
        'collection' => array(
            'index' => array(
                'href' => '/app/site#/index',
                'label' => 'サービスインデックス',
                'ng-class' => '{active: activePath==\'/index\'}',
            ),
            'signin' => array(
                'href' => '/app/site#/signin',
                'label' => 'サインイン/サインアウト',
                'ng-class' => '{active: activePath==\'/signin\'}',
            ),
        )
    );

    public function indexAction()
    {

    }

}
