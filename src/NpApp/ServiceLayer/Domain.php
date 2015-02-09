<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\ServiceLayer;

/**
 * Domainに関する操作用のサービスレイヤー
 * CurrentDomainについては、サービスから自動的に抽入される
 *
 *
 *
 * @author tomoaki
 */
class Domain extends AbstractService
{

    /**
     * 新しいドメインオブジェクトを作って返します。
     * （ここでのDomainはDNS上のドメインいわゆるドメインモデルのドメインではない）
     *
     */
    public function create()
    {

    }

    public function get($domainId)
    {

    }

    /**
     * 特定ドメインに関する情報を保存する
     * 管理者情報の保存
     * グループ管理
     *
     */
    public function save()
    {

    }

}
