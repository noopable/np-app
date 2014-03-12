<?php
//import config
$siteData = include __DIR__ . '/../data/site.php';
$navbar = include __DIR__ . '/../data/navbar.php';

return array(
    'class' => 'Page\Block\BlockArray',
    'blocks' => array(
        'core' => array(
            'options' => array(
                'viewModelBuilder' => array(
                    'policy' => 'delegate',
                ),
                'blockBuilder' => function ($b) use ($siteData) {
                    $sl = $b->getService()->getServiceLocator();
                    $hm = $sl->get('ViewHelperManager');
                    $headTitle = $hm->get('headTitle');
                    $headTitle($siteData['title'])->setSeparator(' - ')->setAutoEscape(false);
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
                'collection' => $navbar,
                'siteData' => $siteData,
            ),
            'order' => 100,
        ],
        'footer' => [
            'class' => 'block',
            'options' => array(
                'template'=>'pages/common/footer',
                'captureTo' => 'footer',
                //'viewModelAppend' => true,
            ),
            'properties' => array(
                'siteData' => $siteData,
            ),
            'order' => 80,
        ],
    ),
);
