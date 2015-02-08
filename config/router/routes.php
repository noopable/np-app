<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    // The following section is new and should be added to your file
    'np-app-top' => array(
        'type'    => 'Literal',
        'options' => array(
            'route'    => '/',
            'defaults' => array(
                '__NAMESPACE__' => 'NpApp\Controller',
                'page'   => 'topPage',
                'module' => 'np-app',
                'controller'    => 'index',
                'action'        => 'index',
            ),
        ),
        'may_terminate' => true,
        'child_routes' => array(
            'index' => include __DIR__ . '/index.php',
            'item' => include __DIR__ . '/item.php',
        ),
    ),
);
