<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Model\SelectStrategy;

use Flower\Model\Strategy\SelectOptionsStrategy;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

/**
 * Description of FilesDownload
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class Files extends SelectOptionsStrategy
{
    protected $options = array(
        'columns' => array('*'),
        'order' => array('order' => 'ASC'),//modelで指定されているかもしれないが。
        'limit' => 20,
    );

    public function select(Select $select)
    {
        //mimetypeはカラムは一つなので複数してあればorであることは自明
        if (isset($this->options['mimetypes'])) {
            $where = new Where;
            $mimetypes = (array) $this->options['mimetypes'];
            $nest = $where->nest();
            foreach ($mimetypes as $mimetype) {
                $nest->or->equalTo('mimetype', $mimetype);
            }
            $nest->unnest();

            $select->where($where);
        }

        return parent::select($select);
    }
}
