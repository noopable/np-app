<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\Includes;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Escaper\Escaper;
use Zend\Stdlib\ArrayUtils;

/**
 *
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class ArticleController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function areasAction()
    {
        $config = $this->getServiceLocator()->get('Config')['site_data'];
        $areas = $config['areas'];
        $dateFormat = $config['archive_date_format'];
        $year = $this->params()->fromRoute('year', null);
        $limit = 3;
        $keys = array_keys($areas);
        $areaDocuments = $areas;

        $repository = $this->getServiceLocator()->get('NpDocument_Repositories')->byName('Document');

        foreach ($keys as $areaKey) {
            if ($year) {
                $resultStrategy = new \NpApp\Model\SelectStrategy\Documents(array('tags' => array($areaKey), 'year' => $year, 'limit' => $limit));
            } else {
                $resultStrategy = new \NpApp\Model\SelectStrategy\Documents(array('tags' => array($areaKey), 'limit' => $limit));
            }
            $collection = $repository->getCollectionWithStrategy($resultStrategy);
            $documents = ArrayUtils::iteratorToArray($collection, false);
            foreach ($documents as $document) {
                $document->safe_title = $this->lineBreakWithBR($document->document_title, 13);
                $document->safe_date = date($dateFormat, strtotime($document->published));
            }
            $areaDocuments[$areaKey]['documents'] = $documents;
        }

        $viewModel = new ViewModel(array('areaDocuments' => $areaDocuments));
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
