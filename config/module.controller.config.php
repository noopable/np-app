<?php
/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

$controllersSet = include __DIR__ . '/controllers/controllers.php';
$invokables = include __DIR__ . '/invokables.php';
foreach ($controllersSet as $ns => $controllers) {
    foreach ($controllers as $name) {
        $invokables[$ns . '\\' . ucfirst($name)] = $ns. '\\' . ucfirst($name) . 'Controller';
    }
}

return array(
    'controllers_set' => $controllersSet,
    'controllers' => array(
        'invokables' => $invokables,
    ),
);

