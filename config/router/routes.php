<?php
return array(
    // The following section is new and should be added to your file
    'routes' => array(
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
            'child_routes' => array(//LIFO
                'debug' => include __DIR__ . '/debug.php',
            ),
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
    ),
);