<?php

namespace <Namespace>\<Module>\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
	
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('<Namespace>_<Module>::<module>_manage');
    }

    /**
     * <Module> List action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            '<Namespace>_<Module>::<module>_manage'
        )->addBreadcrumb(
            __('<Module>'),
            __('<Module>')
        )->addBreadcrumb(
            __('Manage <Module>'),
            __('Manage <Module>')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('<Module>'));
        return $resultPage;
    }
}
