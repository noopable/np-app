<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'type'    => 'Segment',
    'options' => array(
        'route'    => 'item[/:action][/:id][/:remains]',
        'constraints' => array(
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id'     => '[a-zA-Z0-9_-]+',
            'remains' => '.*',
        ),
        'defaults' => array(
            'page'   => 'itemPage',
            'controller' => 'item',
            'action'     => 'show',
        ),
        'may_terminate' => true,
        /*
        'child_routes' => array(
        ),
         *
         */
    ),
);