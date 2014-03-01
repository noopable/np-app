<?php
return array(
    'classes' => array('container'),
    'tag' => '',//ルートレベルのタグをキャンセル
    'inner' => array(
        array(
            'pane_class' => 'Flower\View\Pane\PaneClass\ViewScriptPane',
            'classes' => 'navcontain',
            'var' => 'tests/nil',
        ),
        array(
            'classes' => array('row', 'view'),
            'inner' => array(
                array(
                    'id' => 'docs-content',
                    'classes' => array('push_three', 'nine', 'columns'),
                    'inner' => array(
                        array('var' => 'header',),
                        array('var' => 'content',),
                    ),
                ),
                array(
                    'id' => 'sidebar',
                    'size' => 3,
                    'classes' => array('pull_nine'/*, 'three', 'columns'*/),
                    'var' => 'sidebar',
                ),
            ),
        ),
        array(
            'id' => 'footer',
            'classes' => 'row',
            'inner' => array(
                'size' => 12,
                'var' => 'footer',
            ),
        ),
    ),
);