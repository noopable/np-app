<?php
/**
 * トップページ用の暫定的実装である。
 * ページリソースを呼び出せるようにリファクタリングしていく。
 * ページリソースとしての動作と、コントローラーとしての動作の両方を実装する。
 */

namespace NpApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function sidenavAction()
    {
        return new ViewModel;
    }
    
    public function whatsnewAction()
    {
        //暫定的に、配列を返す
        return array('items' => array('foo' => 'bar'));
        $sl = $this->getServiceLocator();
        if (! $sl->has('NpApp_Repositories')) {
            $message = "NpApp_Repositories not found";
            if (isset($this->logger)) {
                $this->logger->log($message);
            }
            else {
                trigger_error($message, E_USER_WARNING);
            }
            return array('error' => ['message' => $message]);
        }
        
        $repositoryManager = $sl->get('NpApp_Repositories');
        
        $repository = $repositoryManager->byName('Item');

        $whatNew = $repository->getWhatsNew(6);

        return array('items' => $whatNew);
    }

}