<?php
return array(
    'name' => 'app',
    'options' => array(
        'order' => 100,
        'viewModelBuilder' => array(
            'policy' => 'delegate',
        ),
        'blockBuilder' => function ($b) {
            $sl = $b->getService()->getServiceLocator();
            $hm = $sl->get('ViewHelperManager');
            $basePath = $hm->get('basePath')->__invoke();
            $bodyScript = $hm->get('bodyScript');
            $headLink = $hm->get('headLink');
            $css = include __DIR__ . '/../head/css.php';

            $headLink
                ->appendStylesheet($basePath . $css['demo-common'])
                ->appendStylesheet($basePath . $css['demo-1'])
                ->appendStylesheet($basePath . $css['fancytile'])
                ;
            $b->insert('app/angular-lib');
            $b->insert('app/gumby-lib');
            $bodyScript
                ->appendFile($basePath . '/js/dist/docs.example.js')
                ->appendFile($basePath . '/js/dist/app/app.js')
                ->appendFile($basePath . '/js/dist/app/services.js')
                ->appendFile($basePath . '/js/dist/app/controllers.js')
                ->appendFile($basePath . '/js/dist/app/filters.js')
                ->appendFile($basePath . '/js/dist/app/directives.js');
        },
    ),
);
