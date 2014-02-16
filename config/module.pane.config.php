<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'PaneFileService' => 'Flower\View\Pane\Service\ConfigFileServiceFactory',
            'PaneFileListener' => 'Flower\View\Pane\Service\ConfigFileListenerFactory',
            'PaneCacheListener' => 'Flower\View\Pane\Service\PaneCacheListenerFactory',
            'PaneRenderCacheListener' => 'Flower\View\Pane\Service\RenderCacheListenerFactory',
        ),
        'shared' => array(
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'NpPaneManager' => 'Flower\View\Pane\Service\ManagerFactory',
        ),
    ),
    'flower_pane_manager' => include 'pane/pane_manager.php',
    'pane_config_file_listener' => array(
        'file_service' => 'PaneFileService',
    ),
    'pane_config_file' => include 'pane/config_file_options.php',
    'pane_cache_listener' => include 'pane/pane_cache_options.php',
    'render_cache_listener' => include 'pane/render_cache_options.php',
);