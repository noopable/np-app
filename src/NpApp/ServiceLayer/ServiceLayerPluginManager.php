<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\ServiceLayer;

use Flower\ServiceLayer\ServiceLayerPluginManager as AbstractPluginManager;

/**
 * Description of ResourcePluginManager
 *
 * @author tomoaki
 */
class ServiceLayerPluginManager extends AbstractPluginManager
{

    /**
     * クラスを配置する namespace as prefix
     * 他の場所のクラスを使いたいときは、直接getで取得するか、
     * 同じnamespaceにプロキシを配置する。
     *
     * @var string
     */
    protected $pluginNameSpace = 'NpApp\ServiceLayer';

}
