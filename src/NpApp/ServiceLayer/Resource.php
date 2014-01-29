<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\ServiceLayer;

/**
 * Description of ResourceRegistration
 *
 * @author tomoaki
 */
class Resource extends AbstractService
{

    protected $resourceManager;

    public function setResourceManager($resourceManager)
    {
        $this->resourceManager = $resourceManager;
    }

    public function getResourceManager()
    {
        return $this->resourceManager;
    }

    public function save()
    {

    }

    public function read()
    {

    }

}
