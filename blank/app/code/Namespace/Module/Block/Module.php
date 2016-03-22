<?php

namespace <Namespace>\<Module>\Block;

/**
 * <Module> content block
 */
class <Module> extends \Magento\Framework\View\Element\Template
{
    /**
     * <Module> collection
     *
     * @var <Namespace>\<Module>\Model\ResourceModel\<Module>\Collection
     */
    protected $_<module>Collection = null;
    
    /**
     * <Module> factory
     *
     * @var \<Namespace>\<Module>\Model\<Module>Factory
     */
    protected $_<module>CollectionFactory;
    
    /** @var \<Namespace>\<Module>\Helper\Data */
    protected $_dataHelper;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \<Namespace>\<Module>\Model\ResourceModel\<Module>\CollectionFactory $<module>CollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \<Namespace>\<Module>\Model\ResourceModel\<Module>\CollectionFactory $<module>CollectionFactory,
        \<Namespace>\<Module>\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->_<module>CollectionFactory = $<module>CollectionFactory;
        $this->_dataHelper = $dataHelper;
        parent::__construct(
            $context,
            $data
        );
    }
    
    /**
     * Retrieve <module> collection
     *
     * @return <Namespace>\<Module>\Model\ResourceModel\<Module>\Collection
     */
    protected function _getCollection()
    {
        $collection = $this->_<module>CollectionFactory->create();
        return $collection;
    }
    
    /**
     * Retrieve prepared <module> collection
     *
     * @return <Namespace>\<Module>\Model\ResourceModel\<Module>\Collection
     */
    public function getCollection()
    {
        if (is_null($this->_<module>Collection)) {
            $this->_<module>Collection = $this->_getCollection();
            $this->_<module>Collection->setCurPage($this->getCurrentPage());
            $this->_<module>Collection->setPageSize($this->_dataHelper->get<Module>PerPage());
            $this->_<module>Collection->setOrder('published_at','asc');
        }

        return $this->_<module>Collection;
    }
    
    /**
     * Fetch the current page for the <module> list
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->getData('current_page') ? $this->getData('current_page') : 1;
    }
    
    /**
     * Return URL to item's view page
     *
     * @param <Namespace>\<Module>\Model\<Module> $<module>Item
     * @return string
     */
    public function getItemUrl($<module>Item)
    {
        return $this->getUrl('*/*/view', array('id' => $<module>Item->getId()));
    }
    
    /**
     * Return URL for resized <Module> Item image
     *
     * @param <Namespace>\<Module>\Model\<Module> $item
     * @param integer $width
     * @return string|false
     */
    public function getImageUrl($item, $width)
    {
        return $this->_dataHelper->resize($item, $width);
    }
    
    /**
     * Get a pager
     *
     * @return string|null
     */
    public function getPager()
    {
        $pager = $this->getChildBlock('<module>_list_pager');
        if ($pager instanceof \Magento\Framework\Object) {
            $<module>PerPage = $this->_dataHelper->get<Module>PerPage();

            $pager->setAvailableLimit([$<module>PerPage => $<module>PerPage]);
            $pager->setTotalNum($this->getCollection()->getSize());
            $pager->setCollection($this->getCollection());
            $pager->setShowPerPage(TRUE);
            $pager->setFrameLength(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setJump(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame_skip',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            );

            return $pager->toHtml();
        }

        return NULL;
    }
}
