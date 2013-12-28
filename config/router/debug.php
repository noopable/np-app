<?php
return array(
    'type'    => 'segment',
    'options' => array(
        'route'    => '[:controller][/:action][/:id]',
        'constraints' => array(
            'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id'     => '[0-9]+',
        ),
        'defaults' => array(
            'page'   => '',
            'controller' => 'index',
            'action'     => 'index',
        ),
        'may_terminate' => true,
    ),
);