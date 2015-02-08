<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\Includes;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 *
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function createAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * アカウントアクティベーションページでフォームを返却
     */
    public function activationAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }


    public function activateAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function editAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function editPasswordAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function schoolAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * アカウントアクティベーションリクエストがあった後の
     * レスポンスメッセージの表示
     * ※ただし、これテンプレートでよいの？
     * テンプレートならスタティックでよいよね？
     */
    public function messageAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);

        $remains = $this->params()->fromRoute('remains', false);
        if ($remains) {
            $viewModel->setTemplate('np-app/includes/user/message/' . $remains);
        }
        return $viewModel;
    }
    /**
     * appで利用される、AngularJSのテンプレートを吐き出すメソッド
     * 実際にサインインするわけではない。
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function signinAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }
    /**
     * Action called if matched action does not exist
     *
     * @return array
     */
    public function notFoundAction()
    {
        $response   = $this->response;
        $event      = $this->getEvent();
        $routeMatch = $event->getRouteMatch();
        $routeMatch->setParam('action', 'not-found');

        if ($response instanceof HttpResponse) {
            $model = $this->createHttpNotFoundModel($response);
        } else {
            $model = $this->createConsoleNotFoundModel($response);
        }
        $model->setTerminal(true);
        return $model;
    }
}
