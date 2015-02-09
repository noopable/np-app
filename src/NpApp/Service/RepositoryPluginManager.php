<?php
/**
 *
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Service;

use Flower\Model\Service\RepositoryPluginManager as AbstractRPM;

/**
 *
 * @author tomoaki
 */
class RepositoryPluginManager extends AbstractRPM
{
    /**
     * クラスを配置する namespace as prefix
     * 他の場所のクラスを使いたいときは、直接getで取得するか、
     * 同じnamespaceにプロキシを配置する。
     *
     * @var string
     */
    protected $pluginNameSpace = 'NpApp\Model\Repository';
}
