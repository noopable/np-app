<?php
/**
 * ルーティングでコントローラーが指定されていない場合にこのコントローラー名はnot-foundになる。
 * NotFoundControllerでいいと思うが、not-foundでalias指定するべきかどうかは今のところ不明
 *
 * @author tomoaki
 *
 */

namespace NpApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ErrorController extends AbstractActionController
{
    public function notFoundAction()
    {
        //$events  = $this->getApplication()->getEventManager();
        $e = $this->getEvent();
        $result = $e->getResult();
        if ($result instanceof ViewModel) {
            $result->setVariable('message', 'ページが移動した可能性があります。詳しくはお問い合わせください。');
        }
        return $result;
    }

}