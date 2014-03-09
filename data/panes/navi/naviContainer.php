<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */


return array(
    'pane_class' => 'Flower\View\Pane\PaneClass\Collection',
    'containerTag' => 'ul',
    'options' => array(
        'container_attributes' => array(
            'class' => 'eight columns',
        ),
    ),
    'prototype' => array(
        'pane_class' => 'Flower\View\Pane\PaneClass\EntityScriptPane',
        'wrapTag' => '',
        'tag' => 'li',
        'var' => 'snipets/navbar/navi_column',
    ),
);