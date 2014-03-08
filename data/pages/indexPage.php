<?php
return array(
    'class' => 'Page\Block\Page',
    //RouteMatchでコントローラーとアクションが指定されていないとき
    'default_controller' => 'page',
    'default_action' => 'index',
    'properties' => array(
        'charset' => 'utf-8',
        'title' => 'インデックスページ',
        'description' => 'Sample of zf2 page,</head>',
        'keywords' => 'zf2,angularjs,gumby,skeleton',
        'author' => 'kosugi@kips.gr.jp',
        'itemName' => 'sample top',
        'itemDescription' => 'sample contents',
        'itemImage' => 'notfound',
        'pageId' => 'index',
        'ogpImage' => 'notfound',
        'ogpType' => 'landing',
        'pane' => 'base/index',
        'ngBody' => 'ng-app="myApp"',
    ),
    'options' => array(//もしくはビルダーを実装する。
        'blockBuilder' => function ($b) {
            /* @var $b Page\Builder\BlockCallbackBuilder */
            $b->insert('set/base');
            $b->insert('blocks/sidebar',
                array(
                    'properties' => array(
                        'collection' => array(
                            array(
                                'href' => '#c1',
                                'target' => 'c1',
                                'label' => 'c1-label',
                            ),
                            array(
                                'href' => '#c2',
                                'target' => 'c2',
                                'label' => 'c2-label',
                            ),
                            array(
                                'href' => '#c3',
                                'target' => 'c3',
                                'label' => 'c3-label',
                            ),
                            array(
                                'href' => '#c4',
                                'target' => 'c4',
                                'label' => 'c4-label',
                            ),
                        ),
                    ),
                )
            );
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