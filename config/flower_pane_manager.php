<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */


return array(
    'pane_config' => include 'pane_config.php',
    'builder_options' => array(
        'builder_class' => 'Flower\View\Pane\Builder\Builder',
        'pane_class' => 'Flower\View\Pane\PaneClass\Pane',
    ),
    'renderer_class' => 'Flower\View\Pane\PaneRenderer',
    'listener_aggregates' => array(
        'PaneFileListener',
        'PaneCacheListener',
        'PaneRenderCacheListener',
    ),
);