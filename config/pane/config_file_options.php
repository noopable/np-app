<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */


return array(
    'spec_class' => 'Flower\File\Spec\TreeArrayMerge',
    'spec_options' => array(
    ),
    'resolve_spec_class' => 'Flower\File\Spec\Resolver\Tree',
    'resolve_spec_options' => array(
        'map' => [],
        'path_stack' => array(
            'npapp' => __DIR__ . '/../../data/panes',
        ),
    ),
    'cache_spec_options' => array(
        'cache_path' => __DIR__ . '/../../data/cache/panes/file',
    ),
);