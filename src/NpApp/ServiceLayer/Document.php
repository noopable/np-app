<?php

/**
 *
 *
 * @copyright Copyright (c) 2013-2014 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\ServiceLayer;

use NpDocument\Model\Document\DocumentInterface;

/**
 * 一見、リポジトリや、モデル本体と同じことをやっているようだが、目的は
 * ・レイヤー化して一元管理する
 * ・イベントやアクセスコントロールを可能にする機能をリポジトリから切り離す
 * ・現在ドメイン以外のリソースにアクセスできないようにする
 * 　（リポジトリは可能。ドメイン切り替えをサービスとしては維持しない）
 * 複数のリポジトリやサービスを跨いだり、サービスロケーターにアクセスして
 * 必要な情報を取得したりといったことを行う。
 *
 * たとえば、カレントユーザーを探して、現在編集中のドキュメントを特定など。
 *
 * ドキュメントに対して行いたいこと
 * ドキュメントの作成
 *      ドキュメントのタイプに合わせてプロトタイプを提供する＝＞リポジトリがドキュメントクラス毎に処理を行う。
 * ドキュメントリストの提供
 *      ドキュメントに対する操作を開始する入口となる。
 * 　　　発行済みのものもあれば、特定のユーザーが編集中のものもありうる
 * ドキュメントの編集
 * 　　指定されたドキュメントIDのドキュメントを返す
 *      編集によって変更のあったセクションに対して新規リビジョンを作成するのは、
 * 　　セクションリポジトリに任せる
 * ドキュメントの発行
 * 発行済みドキュメントの取り下げ
 * ６．ドキュメントの末梢
 *
 * @author tomoaki
 */
class Document extends AbstractRepoService
{

    protected $repositoryName = 'NpDocument\Model\Repository\Document';

    /**
     * 指定した$type毎の初期オブジェクト（永続化されていない）
     * を返します。IDもありません。
     *
     * @param string $type
     */
    public function create($documentClass = null)
    {
        /** @var \NpDocument\Model\Repository\Document */
        $repository = $this->getRepository();
        if (null !== $documentClass) {
            $params['document_class'] = $documentClass;
        }
        return $repository->createDocument($params);
    }

    public function createFromParams($params)
    {
        //編集用のデータ等からDocumentインスタンスを作成する
    }

    /**
     * 条件を指定したドキュメント検索
     *
     * @param mixed $where
     */
    public function find($where)
    {
        /** @var \NpDocument\Model\Repository\Document */
        return $this->getRepository()->find($where);
    }

    /**
     *
     * masterブランチを取得します。
     * 特定のブランチを取得する場合は(公開用ではそのはずですが）Branchサービスを使ってください。
     *
     * @param string $globalDocumentId
     */
    public function getDocument($documentId)
    {
        return $this->getRepository()->getDocument($documentId);
    }

    public function save(DocumentInterface $document)
    {
        //Documentがsaveを要求しているかどうかをチェック
    }

    public function drop(DocumentInterface $document)
    {
        //ドキュメントのステータスを変更し、パブリッシュ先から削除する
        $publish = $this->getServiceLocator()->get('publish');
        $publish->withDraw($document);
    }

    public function eliminate(DocumentInterface $document)
    {

    }

    public function publish(DocumentInterface $document, $branchId = null)
    {
        //$documentがpublish処理を行われている前提とする？
        $document->branch_publish($branchId);
    }

}
