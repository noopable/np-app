<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'inner' => array(
        array(
            'classes' => array('row', 'view'),
            'inner' => array(
                array(
                    'pane_id' => 'docs_content',
                    'id' => 'docs-content',
                    'size' => 9,
                    'classes' => array('push_three'),
                    'inner' => array(
                        array('var' => 'header',),
                        array('var' => 'content',),
                    ),
                ),
                array(
                    'pane_id' => 'sidebar',
                    'id' => 'sidebar',
                    'size' => 3,
                    'classes' => array('pull_nine'),
                    'var' => 'sidebar',
                    'order' => -100,
                ),
            ),
        ),
    ),
);
