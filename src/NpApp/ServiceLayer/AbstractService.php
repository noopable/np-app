<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\ServiceLayer;

use Flower\ServiceLayer\AbstractService as FlowerAbstractService;
use Flower\Domain\DomainAwareInterface;
use Flower\Domain\DomainAwareTrait;

/**
 * Flower\ServiceLayer\ServiceLayerPluginManagerで扱うことで
 * 　AccessControlできる
 * 　イベント対応できる
 *      イベントを購読するときは、ServiceLayerPluginManagerからEventManagerを取得し
 *      ServiceLayer\Events\EventsProxy::EVENT_INVOKE をリッスンする
 * =個別にファクトリをグローバルに登録するのではなく、ServiceLayerPluginManager経由
 * 　またはDIに登録する
 *
 * サービスレイヤーはサービスロケーターを持つが、オブジェクトとしての状態は持たない。
 * ドメインオブジェクトの取得から操作指示までをコントローラーで行う
 * コントローラーはオブジェクトを受け取り、何かをして返す
 *
 * 状態を持つべき機能はアプリケーションサービスとして別途立て、
 * サービスレイヤーのイベントを監視するか、
 * アクセスコントロールラッパのようにサービスレイヤーへのアクセスを監視する
 *
 * @see Flower\ServiceLayer\AbstractService
 * @method \Zend\ServiceManager\ServiceLocatorInterface getMvcServiceLocator()
 * @method \Flower\ServiceLayer\ServiceLayerPluginManager getServiceLocator()
 *
 * @see Flower\Domain\DomainAwareInterface
 * @method \Flower\Domain\DomainInterface getDomain()
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
abstract class AbstractService extends FlowerAbstractService implements DomainAwareInterface
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
