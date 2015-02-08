<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\Includes;

use NpApp\Controller\Api\AbstractApiController;
use Zend\Json\Json;
use Zend\Stdlib\ArrayUtils;
use Zend\View\Model\ViewModel;

/**
 * @todo プロジェクト毎のモジュール、もしくは環境へ設定情報を委譲すること
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class AttachmentController extends AbstractApiController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * アクセス制御を行うときは、ここにも気を遣うように
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function filesAction()
    {
        $params = $this->params()->fromRoute();
        $query = $this->params()->fromQuery();
        $jsonRequest = $this->getJsonRequest(true);
        $repository = $this->getRepository('Files');
        $where = array();

        $integers = array('offset', 'limit', 'group_id', 'kyogi_id', 'taikai_bumon_id');
        foreach ($integers as $field) {
            if (isset($jsonRequest[$field])) {
                $where[$field] = (int) $jsonRequest[$field];
            } elseif (isset($query[$field])) {
                $where[$field] = (int) $query[$field];
            }
        }

        $strings = array('id', 'name', 'document_name');
        foreach ($strings as $field) {
            if (isset($jsonRequest[$field])) {
                $where[$field] = (string) $jsonRequest[$field];
            } elseif (isset($query[$field])) {
                $where[$field] = (string) $query[$field];
            }
        }

        $cs = array('tags', 'category');
        //@todo タグ検索は実装しにくいかもしれない。

        $columns = array(
            'id' => 'file_id',
        );

        foreach ($columns as $k => $v) {
            if (isset($where[$k])) {
                $where[$v] = $where[$k];
                unset($where[$k]);
            }
        }

        if (isset($jsonRequest['type'])) {
            $data['type'] = (string) $jsonRequest['type'];
        } elseif (isset($query[$field])) {
            $data['type'] = (string) $query['type'];
        }
        //関東高ゴ連
        $where['domain_id'] = 1;

        $options['where'] = $where;
        //orで複数を扱えるようにするべきではないか。
        $options['mimetypes'] = array('application/octet-stream', 'application/pdf');
        $strategy = new \NpApp\Model\SelectStrategy\Files($options);
        $collection = $repository->getCollectionWithStrategy($strategy);

        if ($collection->count()) {
            $data['files'] = ArrayUtils::iteratorToArray($collection, false);
        } else {
            $data['message'] = '添付ファイルはありません。';
            $data['result'] = false;
        }

        $viewModel = new ViewModel($data);
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }


    /**
     * アクセス制御を行うときは、ここにも気を遣うように
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function imagesAction()
    {
        $params = $this->params()->fromRoute();
        $query = $this->params()->fromQuery();
        $jsonRequest = $this->getJsonRequest(true);
        $repository = $this->getRepository('Files');
        $options = array();

        $integers = array('offset', 'limit', 'group_id', 'kyogi_id', 'taikai_bumon_id');
        foreach ($integers as $field) {
            if (isset($jsonRequest[$field])) {
                $options[$field] = (int) $jsonRequest[$field];
            } elseif (isset($query[$field])) {
                $options[$field] = (int) $query[$field];
            }
        }

        $strings = array('id', 'name', 'document_name');
        foreach ($strings as $field) {
            if (isset($jsonRequest[$field])) {
                $options[$field] = (string) $jsonRequest[$field];
            } elseif (isset($query[$field])) {
                $options[$field] = (string) $query[$field];
            }
        }

        $cs = array('tags', 'category');
        //@todo タグ検索は実装しにくいかもしれない。

        $columns = array(
            'id' => 'file_id',
        );

        foreach ($columns as $k => $v) {
            if (isset($options[$k])) {
                $options[$v] = $options[$k];
                unset($options[$k]);
            }
        }

        if (isset($jsonRequest['type'])) {
            $data['type'] = (string) $jsonRequest['type'];
        } elseif (isset($query[$field])) {
            $data['type'] = (string) $query['type'];
        }
        //関東高ゴ連
        $options['domain_id'] = 1;
        //orで複数を扱えるようにするべきではないか。
        $options['mimetype'] = 'image/jpeg';
        $collection = $repository->getCollection($options);

        if ($collection->count()) {
            $data['files'] = ArrayUtils::iteratorToArray($collection, false);
        } else {
            $data['message'] = '添付ファイルはありません。';
            $data['result'] = false;
        }

        $viewModel = new ViewModel($data);
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
