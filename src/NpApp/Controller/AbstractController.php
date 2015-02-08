<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller;

use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

/**
 * App 内用の抽象コントローラー
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
abstract class AbstractController extends AbstractActionController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $repositories;

    protected $prepareView = true;

    protected $page;

    protected $header;

    protected $pane;

    protected $contentTemplate;

    protected $headerCollection;

    protected $headerPane;

    protected $headerTemplate;

    protected $subnaviTemplate;

    protected $subnaviProperties;

    protected $sidebarTemplate;

    protected $sidebarProperties;

    protected $asideTemplate;

    protected $asideProperties;

    protected $asideUserTemplate;

    protected $asideUserProperties;

    protected $whatsNewTemplate;

    protected $whatsNewProperties;

    /**
     * イベントリスナーで処理してもいいわけですが？
     *
     * @param \Zend\Mvc\MvcEvent $e
     * @return type
     */
    public function onDispatch(MvcEvent $e)
    {
        $res = parent::onDispatch($e);
        if ($this->prepareView) {
            $this->prepareView();
        }
        return $res;
    }

    public function prepareView()
    {
        $params = $this->params()->fromRoute('prepare_views', array());
        foreach ($params as $viewName) {
            $method = 'prepare' . ucfirst($viewName);
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    public function preparePane()
    {
        if (isset($this->pane)) {
            $this->getPage()->setProperty('pane', $this->pane);
        }
    }

    public function prepareContent()
    {
        $content = $this->getBlock('content');
        if (isset($this->contentTemplate)) {
            $content->setTemplate($this->contentTemplate);
        }
    }

    public function prepareHeader()
    {
        $header = $this->getBlock('blocks/header');
        if ($this->header) {
            $header->setProperty('header', $this->header);
        }

        if ($this->headerPane) {
            $header->setProperty('pane', $this->headerPane);
        }

        if ($this->headerCollection) {
            $header->setProperty('collection', $this->headerCollection);
        }

        if ($this->headerTemplate) {
            $header->setTemplate($this->headerTemplate);
        }
    }

    public function prepareSubnavi()
    {
        $subnavi = $this->getBlock('blocks/subnavi');

        if ($this->subnaviTemplate) {
            $subnavi->setTemplate($this->subnaviTemplate);
        }

        if ($this->subnaviProperties) {
            foreach ((array) $this->subnaviProperties as $key => $value) {
                $subnavi->setProperty($key, $value);
            }
        }
    }

    public function prepareSidebar()
    {
        $sidebar = $this->getBlock('blocks/sidebar');

        if ($this->sidebarTemplate) {
            $sidebar->setTemplate($this->sidebarTemplate);
        }

        if ($this->sidebarProperties) {
            foreach ((array) $this->sidebarProperties as $key => $value) {
                $sidebar->setProperty($key, $value);
            }
        }
    }

    public function prepareAside()
    {
        $aside = $this->getBlock('blocks/aside');

        if ($this->asideTemplate) {
            $aside->setTemplate($this->asideTemplate);
        }

        if ($this->asideProperties) {
            foreach ((array) $this->asideProperties as $key => $value) {
                $aside->setProperty($key, $value);
            }
        }
    }

    public function prepareAsideUser()
    {
        $asideUser = $this->getBlock('blocks/aside-user');

        if ($this->asideUserTemplate) {
            $asideUser->setTemplate($this->asideUserTemplate);
        }

        if ($this->asideUserProperties) {
            foreach ((array) $this->asideUserProperties as $key => $value) {
                $asideUser->setProperty($key, $value);
            }
        }
    }

    public function getBlock($name)
    {
        return $this->getPage()->byName($name);
    }

    public function getRepository($name)
    {
        return $this->getRepositories()->byName($name);
    }

    public function getRepositories()
    {
        if (!isset($this->repositories)) {
            $this->repositories = $this->getServiceLocator()->get('NpApp_Repositories');
        }
        return $this->repositories;
    }

    public function getPage()
    {
        if (!isset($this->page)) {
            $sl = $this->getServiceLocator();
            $pageService = $sl->get('Page_Service');
            $this->page = $pageService->getPage();
        }
        return $this->page;
    }

    protected function getForm($name, $options)
    {
        $form = $this->getServiceLocator()
                ->get('FormElementManager')
                ->get($name, $options);
        $form->setAttribute('action', $this->url()->fromRoute($this->getOriginalRouteMatch()->getMatchedRouteName()));
        return $form;
    }

    protected function addFlashMessage($message = null)
    {
        $fm = $this->flashMessenger();
        $fm->setNamespace(get_called_class());
        if (null !== $message) {
            $fm->addMessage($message);
        }
        return $fm;
    }

    protected function getFlashMessages()
    {
        $fm = $this->flashMessenger();
        $fm->setNamespace(get_called_class($this));
        return $fm->getMessages();
    }

    public function getAccessControlService()
    {
        //Apiの場合、複数回呼び出すことは稀なのでflyweightはしない。
        //コーディング上のキーの参照・確認を不要にするため
        return $this->getServiceLocator()->get('Flower_AccessControl');
    }

    public function getService($name)
    {
        return $this->getServiceLayer()->get($name);
    }

    public function getServiceLayer()
    {
        return $this->getServiceLocator()->get('NpApp_ServiceLayer');
    }

    /**
     * Add a message as a log entry
     *
     * @param  int $priority
     * @param  mixed $message
     * @param  array|Traversable $extra
     * @return Logger
     * @throws Exception\InvalidArgumentException if message can't be cast to string
     * @throws Exception\InvalidArgumentException if extra can't be iterated over
     * @throws Exception\RuntimeException if no log writer specified
     */
    protected function log($priority, $message, $extra = array())
    {
        if (false === $this->logger) {
            return false;
        }
        return $this->getLogger()->log($priority, $message, $extra);
    }

    /**
     * Get logger object
     *
     * @return null|LoggerInterface
     */
    public function getLogger()
    {
        if (null === $this->logger) {
            $sl = $this->getServiceLocator();
            $loggerName = 'Zend\\Log\\Logger';
            //ServiceLocatorはcanCreateFromAbstractFactoryが、
            //存在するinterfaceを無条件でtrueで返してしまうので、
            //第2引数をfalseにしておく。
            if ($sl->has($loggerName, false)) {
                $this->logger = $sl->get($loggerName);
            } elseif ($sl->has('Di')) {
                $di = $sl->get('Di');
                $im = $di->instanceManager();
                if ($im->hasSharedInstance($loggerName)
                    || $im->hasAlias($loggerName)
                    || $im->hasConfig($loggerName)
                    || $im->hasTypePreferences($loggerName)) {
                    $this->logger = $di->get($loggerName);
                }
            }
        }

        if (!isset($this->logger)) {
            $this->logger = false;
        }

        return $this->logger;
    }
}
