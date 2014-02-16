<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'NpApp\Controller\Index' => 'NpApp\Controller\IndexController',
            'NpApp\Controller\Error' => 'NpApp\Controller\ErrorController',
            'not-found' => 'NpApp\Controller\NotFoundController',
            'StandardPageController'  => 'Flower\Stdlib\Page\Controller\StandardPageController',
        ),
    ),
);

