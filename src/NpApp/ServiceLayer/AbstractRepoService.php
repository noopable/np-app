<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\ServiceLayer;

use Flower\ServiceLayer\AbstractRepoService;
use Flower\Domain\DomainAwareInterface;
use Flower\Domain\DomainAwareTrait;

/**
 * @see \Flower\ServiceLayer\AbstractService
 * @method \Zend\ServiceManager\ServiceLocatorInterface getMvcServiceLocator()
 * @method \Flower\ServiceLayer\ServiceLayerPluginManager getServiceLocator()
 *
 * @see \Flower\ServiceLayer\AbstractRepoService
 * @method \Flower\Model\RepositoryInterface getRepository()
 * @method \Flower\Model\Service\RepositoryPluginManager getRepositoryPluginManager()
 *
 * @see \Flower\Domain\DomainAwareInterface
 * @method \Flower\Domain\DomainInterface getDomain()
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class AbstractRepoService extends AbstractRepoService implements DomainAwareInterface
{

    use DomainAwareTrait;

    protected $resourceId = 'np-app_service';
    protected $domainId;
    protected $domainName;

    public function getDomainId()
    {
        if (!isset($this->domainId)) {
            if (!$domain = $this->getDomain() || (!$domainId = $domain->getDomainId())) {
                throw new DomainException('ServiceLayer needs the current domainId. lack of domain_id in route setting?');
            }
            $this->domainId = $domainId;
        }

        return $this->domainId;
    }

    public function getDomainName()
    {
        if (!isset($this->domainName)) {
            if (!$domain = $this->getDomain() || (!$domainName = $domain->getDomainName())) {
                throw new DomainException('ServiceLayer needs the current domainId. lack of domain_id in route setting?');
            }
            $this->domainName = $domainName;
        }

        return $this->domainName;
    }

    public function getResourceId()
    {
        return $this->getDomainName() . '_' . $this->resourceId;
    }

}
