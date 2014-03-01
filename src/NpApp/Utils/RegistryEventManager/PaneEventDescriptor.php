<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Utils\RegistryEventManager;

use Flower\View\Pane\PaneEvent;

/**
 * Description of PaneEventDescriptor
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class PaneEventDescriptor
{

    const IDENTIFIER_CONFIG = 'pane_cache_config';
    const IDENTIFIER_PANE = 'pane_cache_pane';
    const IDENTIFIER_RENDER = 'pane_cache_render';

    public static function refreshConfigConfig($paneId) {
        return array(
            'identifier' => static::IDENTIFIER_CONFIG, // triggerIdentifier
            'class' => 'pane',//the first parameter to EventPluginManager::get
            'params' => array( // createOptions of  event object
                'paneId' => $paneId,
                'name' => PaneEvent::EVENT_REFRESH_CONFIG,
            ),
        );
    }

    public static function refreshPaneConfig($paneId)
    {
        return array(
            'identifier' => static::IDENTIFIER_PANE, // triggerIdentifier
            'class' => 'pane',//the first parameter to EventPluginManager::get
            'params' => array( // createOptions of  event object
                'paneId' => $paneId,
                'name' => PaneEvent::EVENT_REFRESH_PANE,
            ),
        );
    }

    public static function refreshPaneRender($paneId)
    {
        return array(
            'identifier' => static::IDENTIFIER_RENDER, // triggerIdentifier
            'class' => 'pane',//the first parameter to EventPluginManager::get
            'params' => array( // createOptions of  event object
                'paneId' => $paneId,
                'name' => PaneEvent::EVENT_REFRESH_RENDER,
            ),
        );
    }

    public static function refreshByPaneId($paneId)
    {
        return array(
            static::refreshConfigConfig($paneId),
            static::refreshPaneConfig($paneId),
            static::refreshPaneRender($paneId),
        );
    }

    public static function refreshByPaneIds($ids)
    {
        $ids = array_flip(array_flip((array) $ids));

        $response = array();
        foreach ($ids as $paneId) {
            $response[] = static::refreshConfigConfig($paneId);
            $response[] = static::refreshPaneConfig($paneId);
            $response[] = static::refreshPaneRender($paneId);
        }
        return $response;
    }
}
