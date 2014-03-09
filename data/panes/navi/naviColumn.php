<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */


return array(
    'pane_class' => 'Flower\View\Pane\PaneClass\Collection',
    'containerBegin' => '<div class="dropdown"><ul>',
    'containerEnd' => '</ul></div>',
    'prototype' => array(
        'pane_class' => 'Flower\View\Pane\PaneClass\EntityAnchor',
        'href' => '%s',
        'label' => '%s',
        'options' => array(
            'mutable_params' => array(
                'href', 'label', 'attributes'
            ),
        ),
    ),
);