<?php
/**
 * トップページ用の暫定的実装である。
 * ページリソースを呼び出せるようにリファクタリングしていく。
 * ページリソースとしての動作と、コントローラーとしての動作の両方を実装する。
 */

namespace NpApp\Controller\Includes;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    public function formAction()
    {
        $siteData = $this->getServiceLocator()->get('Config')['site_data'];
        $form = $this->getServiceLocator()
                ->get('FormElementManager')
                ->get('NpApp\Form\ContactForm');
        $viewModel = new ViewModel(array('form' => $form, 'siteData' => $siteData, 'horizon' => true));
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function searchAction()
    {
        //searchフォームなど。
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }


    public function replyAction()
    {
        //replyフォームなど。
        $viewModel = new ViewModel();
        //レイアウトを通さずにレンダリング結果を送る
        $viewModel->setTerminal(true);
        return $viewModel;
    }
}