<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    // The following section is new and should be added to your file
    'home' => array(
        'type'    => 'Literal',
        'options' => array(
            'route'    => '/',
            'defaults' => array(
                '__NAMESPACE__' => 'NpApp\Controller',
                'page'   => 'topPage',
                'controller'    => 'index',
                'action'        => 'index',
            ),
        ),
        'may_terminate' => true,
    ),
    'publish' => array(
        'type' => 'hostname',
        'options' => array(
            'route' => ':subdomain.example.com',
            'constraints' => array(
                'subdomain' => '(publisher)',
            ),
            'defaults' => array(
                '__NAMESPACE__' => 'NpApp\Controller\Publish',//Publishモジュールにリダイレクトすべきかどうか。
                'controller'    => 'index',
                'action'        => 'index',
                'subdomain'     => 'publisher',
            ),
        ),
        'may_terminate' => true,
    ),
);

