<?php
return array(
    'alias' => array( //add alias first !
        //リソースfactoryでブリッジ指定したサービスは、Aliasを張ることでDIで使用可能になる。
        //このalias指定がないと、パラメーターとして指定したときインスタンスと解釈してくれない。
        'dbAdapter' => 'Zend\Db\Adapter\Adapter',
        'ClientTable' =>   'Zend\Db\TableGateway\TableGateway',
    ),
    'preferences' => array(
    ),
    'ClientTable' => array(
        'parameters' => array(
            'table' => 'client',
            'adapter' => 'dbAdapter',
        ),
    ),
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
            'name' => 'clientSession',
            'entityPrototype' => 'NpApp\Model\Client\Client',
            'namespace' => 'NpApp\Client',
        ),
    ),
);