<?php

namespace <Namespace>\<Module>\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

interface <Module>LoaderInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \<Namespace>\<Module>\Model\<Module>
     */
    public function load(RequestInterface $request, ResponseInterface $response);
}
