<?php

namespace NpApp\Service;

/*
 *
 *
 * @copyright Copyright (c) 2013-2013 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

use Flower\File\Service\FileServiceFactoryFromConfig;

/**
 * Description of MenuFilesFactory
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class MenuFilesFactory extends FileServiceFactoryFromConfig
{

    protected $configKey = 'menu_files';

}
