<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'classes' => array('container'),
    'tag' => '',//ルートレベルのタグをキャンセル
    'inner' => array(
        array(
            'classes' => 'navcontain',
            'var' => 'navbar',
            'order' => 10000,
        ),
        array(
            'id' => 'footer',
            'classes' => 'row',
            'order' => -10000,
            'var' => 'footer',
        ),
    ),
);
