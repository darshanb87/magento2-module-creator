<?php
/**
 * Adminhtml <module> list block
 *
 */
namespace <Namespace>\<Module>\Block\Adminhtml;

class <Module> extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_<module>';
        $this->_blockGroup = '<Namespace>_<Module>';
        $this->_headerText = __('<Module>');
        $this->_addButtonLabel = __('Add New <Module>');
        parent::_construct();
        if ($this->_isAllowedAction('<Namespace>_<Module>::save')) {
            $this->buttonList->update('add', 'label', __('Add New <Module>'));
        } else {
            $this->buttonList->remove('add');
        }
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
