<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'type'    => 'Segment',
    'options' => array(
        'route'    => 'index[/:action][/:remains]',
        'constraints' => array(
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'remains' => '.*',
        ),
        'defaults' => array(
            'page'   => 'indexPage',
            'controller' => 'index',
            'action'     => 'index',
        ),
        'may_terminate' => true,
    ),
);