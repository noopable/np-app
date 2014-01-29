<?php

/*
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\ServiceLayer;

use Flower\ServiceLayer\ServiceLayerPluginManagerFactory as AbstractFactory;

/**
 * Description of ServiceLayerPluginManagerFactory
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class ServiceLayerPluginManagerFactory extends AbstractFactory
{

    protected $pluginClass = 'NpApp\ServiceLayer\ServiceLayerPluginManager';
    protected $configId = 'np-app_service_layer';

}
