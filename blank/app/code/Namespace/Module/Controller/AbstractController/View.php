<?php

namespace <Namespace>\<Module>\Controller\AbstractController;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

abstract class View extends Action\Action
{
    /**
     * @var \<Namespace>\<Module>\Controller\AbstractController\<Module>LoaderInterface
     */
    protected $<module>Loader;
	
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param OrderLoaderInterface $orderLoader
	 * @param PageFactory $resultPageFactory
     */
    public function __construct(Action\Context $context, <Module>LoaderInterface $<module>Loader, PageFactory $resultPageFactory)
    {
        $this-><module>Loader = $<module>Loader;
		$this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * <Module> view page
     *
     * @return void
     */
    public function execute()
    {
        if (!$this-><module>Loader->load($this->_request, $this->_response)) {
            return;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
		return $resultPage;
    }
}
