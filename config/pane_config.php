<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

/**
 * configに書いたファイルはmodule.config.phpと同じタイミングでキャッシュされる。
 * プロジェクト内で長期にキャッシュされても問題がない設定をここに書く。
 */
return array(
    'sandbox' => array(
        'pane_class' => 'Flower\View\Pane\PaneClass\Anchor',
        'classes' => 'container',
        'var' => 'Link Label 1',// this will be omitted
        'inner' => array(
            'classes' => 'main',
            'var' => 'Link Label 1.1',
            'inner' => array(
                'classes' => 'main',
                'var' => 'Link Label 1.1.1',
            ),
        ),
    ),
);
