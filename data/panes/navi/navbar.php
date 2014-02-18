<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */
return array(
    'pane_class' => 'Flower\View\Pane\PaneClass\Anchor',
    'tag' => 'ul',
    'size' => 8,
    'inner' => array(
        array(
            'label' => 'Demo',
            'href' => '#',
        ),
        array(
            'label' => 'AngularDemo',
            'href' => '#',
            'wrapBegin' => '<div class="dropdown">
            <ul>',
            'wrapEnd' => '</ul></div>',
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
            'wrapBegin' => '<div class="dropdown">
            <ul>',
            'wrapEnd' => '</ul></div>',
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
        ),
    ),
);

