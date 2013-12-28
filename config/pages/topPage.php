<?php
return array(
    'class' => 'Page\Block\Page',
    //RouteMatchでコントローラーとアクションが指定されていないとき
    'default_controller' => 'page',
    'default_action' => 'index',
    'properties' => array(
        'charset' => 'utf-8',
        'title' => 'トップページ',
        'description' => 'Sample of zf2 page,</head>',
        'keywords' => 'zf2,angularjs,gumby,skeleton',
        'author' => 'kosugi@kips.gr.jp',
        'itemName' => 'sample top',
        'itemDescription' => 'sample contents',
        'itemImage' => 'notfound',
        'pageId' => 'top',
        'ogpImage' => 'notfound',
        'ogpType' => 'landing',
        'pane' => include __DIR__ . '/pane/draft1.php',
        'ngBody' => 'ng-app="myApp"',
    ),
    'options' => array(//もしくはビルダーを実装する。
        'blockBuilder' => function ($b) {
            /* @var $b Page\Builder\BlockCallbackBuilder */
            $b->insert('set/base');
            $b->insert('blocks/sidebar', array('foo' => 'bar'));
            $b->block('content',
                 array(
                    'options' => array(
                        'template'=>'np-app/index/index',
                        //'captureTo' => 'content',
                        'viewModelAppend' => true,
                    ),
                    'order' => 80,
                )
            );
            $b->insert('app/sample1');
        },
    ),
);