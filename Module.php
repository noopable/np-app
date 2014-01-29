<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp;

use Zend\Mvc\MvcEvent;

class Module
{
    protected $errorPage = 'errorPage';

    public function onBootstrap(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $translator = $serviceManager->get('MvcTranslator');
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);

        $router = $serviceManager->get('Router');
        \Zend\Navigation\Page\Mvc::setDefaultRouter($router);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        $config =  include __DIR__ . '/config/module.config.php';
        $config['router']['routes'] = include __DIR__ . '/config/module.routes.php';
        return $config;
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                /**
                 * Module Configのキャッシュの回避、
                 * ZfcUserのサービスエイリアスでの利用
                 *
                 */
                'db_adapter' => function($sm) {
                    $di = $sm->get('Di');
                    return $di->get('dbAdapter');
                },
            ),
        );
    }

}
