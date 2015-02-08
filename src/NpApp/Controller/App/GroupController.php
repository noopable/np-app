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
 * 
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class DomainController extends AbstractController
{

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

    public function loginAction()
    {
        $data = array(
            'foo' => 'bar',
        );
        $viewModel = new JsonModel($data);
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}
