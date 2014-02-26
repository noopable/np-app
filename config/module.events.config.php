<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

/**
 *
 * @see module.pane.config.php
 */
return array(
    'service_manager' => array(
        //Module.phpの getServiceConfigでも実装できる。ハードコートしたくなければこちらで。
        'factories' => array(
            'RegistryEventManager' => 'Flower\EventManager\Service\RegistryEventManagerFactory',
            'Flower_Event_Registry' => 'Flower\EventManager\Service\RegistryFactory',
        ),
    ),
    'flower_registry_event_manager' => array(
        'event_plugins' => array(
            'aliases' => array(
                'pane' => 'Flower\View\Pane\PaneEvent',
            ),
            'classes' => array(
                'Flower\View\Pane\PaneEvent'
            ),
        ),
        'callbacks' => array(
            array(
                'identifier' => 'pane_cache_config',
                'event' => Flower\View\Pane\PaneEvent::EVENT_REFRESH_CONFIG,
                'callback' => 'PaneFileListener',
                'callback_method' => 'onRefresh',
            ),
            array(
                'identifier' => 'pane_cache_pane',
                'event' => Flower\View\Pane\PaneEvent::EVENT_REFRESH_PANE,
                'callback' => 'PaneCacheListener',
                'callback_method' => 'onRefresh',
            ),
            array(
                'identifier' => 'pane_cache_render',
                'event' => Flower\View\Pane\PaneEvent::EVENT_REFRESH_RENDER,
                'callback' => 'PaneRenderCacheListener',
                'callback_method' => 'onRefresh',
            ),
        ),
    ),
    'flower_events_registry' => array(
        'spec_class' => 'Flower\File\Spec\TreeArrayMerge',
        'resolve_spec_class' => 'Flower\File\Spec\Resolver\Tree',
        'resolve_spec_options' => array(
            'path_stack' => array(
                'npapp' => __DIR__ . '/../data/events',
            ),
        ),
    ),
);