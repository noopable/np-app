<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\Api;

use Zend\Stdlib\ArrayUtils;

/**
 * 直接外部へデータを供給することが目的ではなく、
 * jsonの静的ファイルをジェネレートするために使用する。
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class ResourceController extends AbstractApiController
{

    public function indexAction()
    {

    }

    /**
     * 
     * @todo check admin role
     * @return type
     */
    public function createAddressResourceAction()
    {
        $repository = $this->getRepository('Address');
        $collection = $repository->getCollection();
        $data = ArrayUtils::iteratorToArray($collection, false);
        return $this->returnJsonTerminalModel($data);
    }
}
