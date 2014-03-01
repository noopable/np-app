<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */


return array(
    'pane_class' => 'Flower\View\Pane\PaneClass\Collection',
    'containerTag' => 'ul',
    'prototype' => array(
        'pane_class' => 'Flower\View\Pane\PaneClass\EntityScriptPane',
        'var' => 'tests/entity',// var_export($entity)
        'wrapTag' => '',
        'tag' => 'li',
        'classes' => array('tile'),
    ),
);