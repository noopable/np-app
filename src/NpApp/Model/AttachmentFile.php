<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Model;

use Flower\Model\AbstractEntity;
use Zend\Escaper\Escaper;

/**
 * Description of Files
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
class AttachmentFile extends AbstractEntity
{

    public function getIdentifier()
    {
        return array('file_id');
    }

    public function getPath()
    {
        if (!defined('FILES_DIR')) {
            throw new \NpApp\Exception\DomainException('AttachmentFile needs FILES_DIR constance');
        }
        if (strlen($this->path) === 0) {
            return '';
        }
        if (preg_match('#\.\.[\\\/]#', $this->path)) {
            throw new \NpApp\Exception\DomainException('path cannot include double dot');
        }
        return FILES_DIR . DIRECTORY_SEPARATOR . $this->path;
    }

    public function getUrl()
    {
        defined('FILES_BASE_URL') or define('FILES_BASE_URL', '/');
        if (!isset($this->path) ||  !strlen($this->path)) {
            return '';
        }
        return rtrim(FILES_BASE_URL, '/') . '/'. $this->path;
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'path':
                if (preg_match('#\.\.[\\\/]#', $value)) {
                    throw new \NpApp\Exception\DomainException('path cannot include double dot');
                }
                return parent::__set($name, $value);
            default:
                return parent::__set($name, $value);
        }
    }
}
