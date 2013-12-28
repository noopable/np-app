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
            
            $headLink->prependStylesheet($basePath() . '/css/dist/gumby.css');
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