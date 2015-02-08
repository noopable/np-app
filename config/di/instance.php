<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

$tables      = include __DIR__ . '/instance.tables.php';
$instances = include __DIR__ . '/instance.models.php';

/**
 * alias
 * preferences
 */
return array_merge($tables, $instances);