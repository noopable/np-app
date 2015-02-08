<?php

/**
 *
 * @copyright Copyright (c) 2013-2015 KipsProduction (http://www.kips.gr.jp)
 * @license   http://www.kips.gr.jp/newbsd/LICENSE.txt New BSD License
 */

namespace NpApp\Controller\Api;

use Zend\Json\Json;
use Zend\Log\LoggerAwareInterface;
use Zend\Log\LoggerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Resource\ResourceInterface;
use Zend\View\Model\JsonModel;

/**
 * Description of AbstractApiController
 *
 * @author Tomoaki Kosugi <kosugi at kips.gr.jp>
 */
abstract class AbstractApiController extends AbstractActionController implements ResourceInterface
{
    use LoggerAwareTrait;

    protected $resourceId;

    protected $jsonRequest;

    protected $isValidTokenRequest;

    protected $invalidTokenReason = array();

    /**
     *
     * @return stdClass|[]
     */
    public function getJsonRequest($returnArray = false)
    {
        if (!isset($this->jsonRequest)) {
            $this->jsonRequest = Json::decode($this->getRequest()->getContent(), Json::TYPE_OBJECT);
        }
        if ($returnArray && is_object($this->jsonRequest)) {
            return get_object_vars($this->jsonRequest);
        }
        return $this->jsonRequest;
    }

    public function returnJsonTerminalModel(array $data = null)
    {
        $this->getResponse()->getHeaders()->addHeaders(array(
            'X-Content-Type-Options' => 'nosniff',
        ));
        if (null === $data) {
            $data = array();
        }
        $callback = $this->getRequest()->getQuery('callback', false);
        $jsonModel = new JsonModel($data);
        $jsonModel->setTerminal(true);
        if ($this->isValidJsCallback($callback)) {
            //application/javascript
            //この方法だとcontentTypeがあとでapplication/jsonで上書きされてしまいます。
            //$jsonModel->setJsonpCallback($callback);
            $jsonRenderer = $this->getServiceLocator()->get('ViewJsonRenderer');
            $jsonRenderer->setJsonpCallback($callback);
            if (!$this->isValidTokenRequest) {
                $data = array(
                    'invalid_token_request' => 'invalid token request',
                    'invalid_token_reason' => $this->invalidTokenReason,
                );
                $jsonModel->setVariables($data, true);
            }
        } else {
            // http://js.studio-kingdom.com/angularjs/ng_service/$http
            //@todo
            echo ")]}',\n";
        }

        return $jsonModel;
    }

    /**
     * Register the default events for this controller
     *
     * @return void
     */
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        $events = $this->getEventManager();
        $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatchPre'), 10);
    }

    public function onDispatchPre (MvcEvent $e)
    {
        $this->checkXsrfToken();
    }

    protected function checkXsrfToken()
    {
        $xsrfCookieName = 'XSRF-TOKEN';
        $cookies = $this->getRequest()->getCookie();
        $sessionToken = $this->getServiceLocator()->get('np_app_xsrf_token');
        $cookieToken = isset($cookies->$xsrfCookieName) ? $cookies->$xsrfCookieName : false;
        //ajaxリクエストであるかどうかはここでは検証しない。
        //ブロックしても構わないが、外部ツール等の開発を考えれば、ajaxである必要はない。
        if ($sessionToken === $cookieToken) {
            $this->isValidTokenRequest = true;
        } else {
            $this->invalidTokenReason[] = array('sessionToken' => $sessionToken, 'cookieToken' => $cookieToken);
        }
    }


    public function getService($name)
    {
        return $this->getServiceLayer()->get($name);
    }

    public function getServiceLayer()
    {
        return $this->getServiceLocator()->get('NpApp_ServiceLayer');
    }

    public function getAccessControlService()
    {
        //Apiの場合、複数回呼び出すことは稀なのでflyweightはしない。
        //コーディング上のキーの参照・確認を不要にするため
        return $this->getServiceLocator()->get('Flower_AccessControl');
    }

    /**
     * use controller as resource
     *
     * @return system
     */
    public function getResourceId()
    {
        if (! isset($this->resourceId)) {
            return get_class($this);
        }

        return $this->resourceId;
    }

    protected function isValidJsCallback($callback)
    {
        $jsonWords = array(
            'abstract',
            'boolean',
            'break',
            'byte',
            'case',
            'catch',
            'char',
            'class',
            'const',
            'continue',
            'debugger',
            'default',
            'delete',
            'do',
            'double',
            'else',
            'enum',
            'export',
            'extends',
            'false',
            'final',
            'finally',
            'float',
            'for',
            'function',
            'goto',
            'if',
            'implements',
            'import',
            'in',
            'instanceof',
            'int',
            'interface',
            'long',
            'native',
            'new',
            'null',
            'package',
            'private',
            'protected',
            'public',
            'return',
            'short',
            'static',
            'super',
            'switch',
            'synchronized',
            'this',
            'throw',
            'throws',
            'transient',
            'true',
            'try',
            'typeof',
            'var',
            'volatile',
            'void',
            'while',
            'with',
            'NaN',
            'Infinity',
            'undefined',
        );
        if (1 === preg_match( '/[^.0-9a-zA-Z_]|^(' . implode('|', $jsonWords) . ')$/', $callback)) {
            return false;
        }
        return true;
    }

    public function getRepository($name)
    {
        //サービスレイヤーに任せるべきかもしれないが？
        return $this->getRepositories()->byName($name);
    }

    public function getRepositories()
    {
        if (!isset($this->repositories)) {
            $this->repositories = $this->getServiceLocator()->get('NpApp_Repositories');
        }
        return $this->repositories;
    }

    /**
     * Add a message as a log entry
     *
     * @param  int $priority
     * @param  mixed $message
     * @param  array|Traversable $extra
     * @return Logger
     * @throws Exception\InvalidArgumentException if message can't be cast to string
     * @throws Exception\InvalidArgumentException if extra can't be iterated over
     * @throws Exception\RuntimeException if no log writer specified
     */
    protected function log($priority, $message, $extra = array())
    {
        if (false === $this->logger) {
            return false;
        }
        return $this->getLogger()->log($priority, $message, $extra);
    }

    /**
     * Get logger object
     *
     * @return null|LoggerInterface
     */
    public function getLogger()
    {
        if (null === $this->logger) {
            $sl = $this->getServiceLocator();
            $loggerName = 'Zend\\Log\\Logger';
            //ServiceLocatorはcanCreateFromAbstractFactoryが、
            //存在するinterfaceを無条件でtrueで返してしまうので、
            //第2引数をfalseにしておく。
            if ($sl->has($loggerName, false)) {
                $this->logger = $sl->get($loggerName);
            } elseif ($sl->has('Di')) {
                $di = $sl->get('Di');
                $im = $di->instanceManager();
                if ($im->hasSharedInstance($loggerName)
                    || $im->hasAlias($loggerName)
                    || $im->hasConfig($loggerName)
                    || $im->hasTypePreferences($loggerName)) {
                    $this->logger = $di->get($loggerName);
                }
            }
        }

        if (!isset($this->logger)) {
            $logger = new Logger;
            $writer = new Stream('php://stderr');
            $logger->setWriter($writer);
            $this->logger = $logger;
        }

        return $this->logger;
    }
}
