<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'tag' => '',//rootレベルのタグをキャンセル（親Paneで設定される)
    'inner' => array(
        array(
            'tag' => 'h2',
            'var' => 'header',
            'size' => 7,
            'order' => 1,
        ),
        array(
            'pane_class' => 'Flower\View\Pane\PaneClass\Collection',
            'pane_id' => 'tiles',
            'containerTag' => 'ul',
            'options' => array(
                'container_attributes' => array(
                    'id' => 'top-tile-container',
                    'class' => 'five columns',
                ),
            ),
            'prototype' => array(
                'pane_class' => 'Flower\View\Pane\PaneClass\EntityScriptPane',
                'var' => 'pages/top/header/tile',
                'wrapTag' => '',
                'tag' => 'li',
                'classes' => array('tile'),
            ),
        ),
    ),
);
