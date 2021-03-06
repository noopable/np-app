<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Model;

use Flower\Model\AbstractEntity;

/**
 * Description of Contact
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class Contact extends AbstractEntity
{
    protected $maskFields = array('person_id', 'domain_id');

    public function getIdentifier()
    {
        return array('contact_id', 'domain_id');
    }

}
