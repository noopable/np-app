<?php
return array(
    'class' => 'Page\Block\BlockArray',
    'blocks' => array(
        'core' => array(
            'options' => array(
                'viewModelBuilder' => array(
                    'policy' => 'delegate',
                ),
                'blockBuilder' => function ($b) {
                    $sl = $b->getService()->getServiceLocator();
                    $hm = $sl->get('ViewHelperManager');
                    $headTitle = $hm->get('headTitle');
                    $headTitle('Zend Framework2, AngularJS, GumbyFramework Demo')->setSeparator(' - ')->setAutoEscape(false);
                },
            ),
        ),
        'modernizr' => array(
            'options' => array(
                'viewModelBuilder' => array(
                    'policy' => 'delegate',
                ),
                'blockBuilder' => function ($b) {
                    $sl = $b->getService()->getServiceLocator();
                    $hm = $sl->get('ViewHelperManager');
                    $basePath = $hm->get('basePath');
                    $headScript = $hm->get('headScript');
                    $headScript
                        ->prependFile($basePath() . '/js/libs/modernizr-2.6.2.min.js');
                },
            ),
        ),
        'navbar' => [
            'options' =>
            [
                'template'=>'snipets/navbar/navbar',
                'captureTo' => 'navbar',
                //'viewModelAppend' => true,
            ],
            'properties' => array(
                'navId' => 'nav4',
                'collection' => include __DIR__ . '/../data/navbar.php',
                'siteData' => include __DIR__ . '/../data/site.php',
            ),
            'order' => 100,
        ],
        'header' => [
            'options' =>
            [
                'template'=>'pages/widget/header',
                'captureTo' => 'header',
                //'viewModelAppend' => true,
            ],
            'properties' => array(
            ),
            'order' => 100,
        ],
        'footer' => [
            'class' => 'block',
            'options' => array(
                'template'=>'pages/widget/footer',
                'captureTo' => 'footer',
                //'viewModelAppend' => true,
            ),
            'order' => 80,
        ],
    ),
);
