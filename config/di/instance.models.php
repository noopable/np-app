<?php
return array(
    'alias' => array( //add alias first !
        //リソースfactoryでブリッジ指定したサービスは、Aliasを張ることでDIで使用可能になる。
        //このalias指定がないと、パラメーターとして指定したときインスタンスと解釈してくれない。
        'dbAdapter' => 'Zend\Db\Adapter\Adapter',
        'NpAppCollection' => 'NpApp\Model\Repository\NpApp\NpAppCollection',
        'ItemTable' => 'Zend\Db\TableGateway\TableGateway',
        'ClientTable' =>   'Zend\Db\TableGateway\TableGateway',
        'SandboxTable' =>   'Zend\Db\TableGateway\TableGateway',
    ),
    'preferences' => array(
    ),
    'SandboxTable' => array(
        'parameters' => array(
            'table' => 'sandbox',
            'adapter' => 'dbAdapter',
        ),
    ),
    'NpApp\Model\Repository\Sandbox' => array(
        'parameters' => array(
            'name' => 'sandbox',
            'entityPrototype' => 'NpApp\Model\Sandbox\Sandbox',
            'tableGateway' => 'SandboxTable',
        ),
    ),
    'ClientTable' => array(
        'parameters' => array(
            'table' => 'client',
            'adapter' => 'dbAdapter',
        ),
    ),
    //'Zend\InputFilter\InputFilter' => array(),
    'NpApp\Model\Client\Client' => array(
        'parameters' => array(
            'array' => array(),
        ),
    ),
    'NpApp\Model\Repository\ClientDb' => array(
        'parameters' => array(
            'name' => 'client',
            'entityPrototype' => 'NpApp\Model\Client\Client',
            'tableGateway' => 'ClientTable',
        ),
    ),
    'NpApp\Model\Repository\ClientSession' => array(
        'parameters' => array(
            'name' => 'cart',
            'entityPrototype' => 'NpApp\Model\Client\Client',
            'namespace' => 'NpApp\Client',
        ),
    ),
);