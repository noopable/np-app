<?php
//ページではテンプレートはレイアウトスクリプトである。内部にコンテナを実装するかどうか。複雑なページでは役に立つだろう。
return array(
    'name' => 'error',
    'properties' => array(
        'title' => 'エラー',
        'pane' => 'base/top',
    ),
    'options' => array(
        'blockBuilder' => function ($b) {
                $b->insert('set/base');
        },
    ),
);