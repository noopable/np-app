<?php
$config = array();
$aliases = array();
$tables = array(
    'address',
    'contact',
    'domain_person',
    'domain',
    'email',
    'files',
    'group',
    'person',
);
foreach ($tables as $table) {
    $camelString = '';
    $aTable = explode('_', $table);
    $camelTable = implode('', array_map('ucfirst', $aTable)) . 'Table';
    $aliases[$camelTable] =  'Zend\Db\TableGateway\TableGateway';
    $config[$camelTable] = array(
         'parameters' => array(
            'table' => $table,
            'adapter' => 'dbAdapter',
        ),
    );
}

$aliases['dbAdapter'] = 'Zend\Db\Adapter\Adapter';

$config['alias'] = $aliases;
$config['preferences'] = array();
$config['Flower\Model\Service\RepositoryPluginManager'] = array(
    'injections' => array(
        'setPluginNameSpace' => array(
            array('NpApp\Model\Repository'),
        ),
    ),
);

return $config;