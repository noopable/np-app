<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    array(
        'identifier' => 'pane_cache_config', // triggerIdentifier
        'class' => 'pane',//the first parameter to EventPluginManager::get
        'params' => array( // createOptions of  event object
            'id' => 'top',
            'paneId' => 'base/top',
            'name' => Flower\View\Pane\PaneEvent::EVENT_REFRESH_CONFIG,
        ),
    ),
    array(
        'identifier' => 'pane_cache_pane', // triggerIdentifier
        'class' => 'pane',//the first parameter to EventPluginManager::get
        'params' => array( // createOptions of  event object
            'id' => 'top',
            'paneId' => 'base/top',
            'name' => Flower\View\Pane\PaneEvent::EVENT_REFRESH_PANE,
        ),
    ),
    array(
        'identifier' => 'pane_cache_render', // triggerIdentifier
        'class' => 'pane',//the first parameter to EventPluginManager::get
        'params' => array( // createOptions of  event object
            'id' => 'top',
            'paneId' => 'base/top',
            'name' => Flower\View\Pane\PaneEvent::EVENT_REFRESH_RENDER,
        ),
    ),
);
