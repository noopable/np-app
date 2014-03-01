<?php
return array(
    'name' => 'gumby-lib',
    'options' => array(
        'viewModelBuilder' => array(
            'policy' => 'delegate',
        ),
        'blockBuilder' => function ($b) {
            $sl = $b->getService()->getServiceLocator();
            $hm = $sl->get('ViewHelperManager');
            $basePath = $hm->get('basePath');
            $bodyScript = $hm->get('bodyScript');
            $headLink = $hm->get('headLink');
            $css = include __DIR__ . '/../head/css.php';
            $headLink->prependStylesheet($basePath() . $css['gumby']);
            $bodyScript
                ->setAllowArbitraryAttributes(true)
                ->prependFile($basePath() . '/js/libs/gumby/main.js')
                ->prependFile($basePath() . '/js/libs/gumby/plugins.js')
                ->prependFile($basePath() . '/js/gumby.min.js',
                        'text/javascript',
                        array('gumby-debug' => '', 'gumby-touch' => 'js/libs/gumby'));
        },
    ),
);