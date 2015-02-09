<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Model\Repository;

use Flower\Person\EmailRepository;
use NpApp\Service\PasswordHash;

/**
 * Description of Email
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class Email extends EmailRepository
{
    public function hash($credential)
    {
        return PasswordHash::hash($credential);
    }
}
