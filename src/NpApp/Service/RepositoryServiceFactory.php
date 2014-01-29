<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Service;

use Flower\Model\Service\RepositoryServiceFactory as AbstractRSF;

/**
 * Description of RepositoryServiceFactory
 *
 * @author tomoaki
 */
class RepositoryServiceFactory extends AbstractRSF
{

    /**
     *
     * @var string
     */
    protected $configId = 'np-app_repositories';

    /**
     *
     * @var string
     */
    protected $managerClass = 'NpApp\Service\RepositoryPluginManager';

    /**
     * whether or not use DependencyInjector
     *
     * @var bool
     */
    protected $useDi = true;

}
