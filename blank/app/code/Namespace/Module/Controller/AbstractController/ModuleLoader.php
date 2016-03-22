<?php

namespace <Namespace>\<Module>\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class <Module>Loader implements <Module>LoaderInterface
{
    /**
     * @var \<Namespace>\<Module>\Model\<Module>Factory
     */
    protected $<module>Factory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \<Namespace>\<Module>\Model\<Module>Factory $<module>Factory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \<Namespace>\<Module>\Model\<Module>Factory $<module>Factory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this-><module>Factory = $<module>Factory;
        $this->registry = $registry;
        $this->url = $url;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return bool
     */
    public function load(RequestInterface $request, ResponseInterface $response)
    {
        $id = (int)$request->getParam('id');
        if (!$id) {
            $request->initForward();
            $request->setActionName('noroute');
            $request->setDispatched(false);
            return false;
        }

        $<module> = $this-><module>Factory->create()->load($id);
        $this->registry->register('current_<module>', $<module>);
        return true;
    }
}
