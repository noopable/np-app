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
            'id' => 'sidebar-nav',
            'gumby-fixed' => 1,
            'gumby-top' => 'top',
        ),
    ),
    'prototype' => array(
        'pane_class' => 'Flower\View\Pane\PaneClass\EntityAnchor',
        'href' => '%s',
        'label' => '%s',
        'class' => 'skip',
        'attributes' => array(
            'gumby-offset' => -100,
            'gumby-update' => null,
            'gumby-duration' => 600,
            'gumby-goto' => "[data-target='%s']",
        ),
        'options' => array(
            'attr_options' => array(
                'gumby-goto' => array('no-escape' => true),
            ),
        ),
    ),
);

