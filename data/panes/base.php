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
            'pane_class' => 'Flower\View\Pane\PaneClass\ViewScriptPane',
            'classes' => 'navcontain',
            'var' => 'snipets/navbar/navbar',
            'order' => 10000,
        ),
        array(
            'id' => 'footer',
            'classes' => 'row',
            'order' => -10000,
            'inner' => array(
                'size' => 12,
                'var' => 'footer',
            ),
        ),
    ),
);
