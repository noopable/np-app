<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'inner' => array(
        array(
            'classes' => array('row'),
            'id' => 'header',
            'var' => 'header',
        ),
        array(
            'classes' => array('row', 'view'),
            'inner' => array(
                array(
                    'pane_id' => 'content',
                    'id' => 'content',
                    'size' => 9,
                    //'classes' => array('push_three'),
                    'var' => 'content',
                ),
                array(
                    'pane_id' => 'sidebar',
                    'id' => 'sidebar',
                    'size' => 3,
                    //'classes' => array('pull_nine'),
                    'var' => 'sidebar',
                    'order' => -100,
                ),
            ),
        ),
    ),
);
