<?php

/**
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

return array(
    'name' => 'header',
    'options' =>
    [
        'template'=>'pages/common/header',
        'captureTo' => 'header',
        //'viewModelAppend' => true,
    ],
    'properties' => array(
        'pane' => 'widget/header/header',
        'header' => 'sample header',
    ),
    'order' => 100,
);
