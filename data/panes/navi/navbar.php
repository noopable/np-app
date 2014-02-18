<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */
return array(
    'pane_class' => 'Flower\View\Pane\PaneClass\Anchor',
    'containerTag' => 'ul',
    'wrapTag' => 'div',//自コンテンツがない場合は使われない。
    'tag' => 'span',
    'options' => array(
        'container_attributes' => array(
            'class' => 'eight columns',
        ),
    ),
    'size' => 8,
    'inner' => array(
        array(
            'label' => 'Demo',
            'href' => '#',
            'containerBegin' => '<div class="dropdown"><ul>',
            'containerEnd' => '</ul></div>',
        ),
        array(
            'label' => 'AngularDemo',
            'href' => '#',
            'containerBegin' => '<div class="dropdown"><ul>',
            'containerEnd' => '</ul></div>',
            'inner' => array(
                array(
                    'label' => 'demo-dist',
                    'href' => 'angular-demo.html',
                ),
                array(
                    'label' => 'demo-async',
                    'href' => 'angular-async.html',
                ),
            ),
        ),
        array(
            'label' => 'GumbyDemo',
            'href' => '#',
            'containerBegin' => '<div class="dropdown"><ul>',
            'containerEnd' => '</ul></div>',
            'inner' => array(
                array(
                    'label' => '960 grid',
                    'href' => 'gumby-960grid.html',
                ),
                array(
                    'label' => 'FancyTiles',
                    'href' => 'gumby-grid-fancytile.html',
                ),
                array(
                    'label' => 'Gumby UI',
                    'href' => 'gumby-ui.html',
                ),
            ),
        ),
        array(
            'label' => 'Contact',
            'href' => '#',
            'containerBegin' => '<div class="dropdown"><ul>',
            'containerEnd' => '</ul></div>',
        ),
    ),
);

