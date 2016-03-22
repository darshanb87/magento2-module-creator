<?php

namespace <Namespace>\<Module>\Model;

/**
 * <Module> Model
 *
 * @method \<Namespace>\<Module>\Model\Resource\Page _getResource()
 * @method \<Namespace>\<Module>\Model\Resource\Page getResource()
 */
class <Module> extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('<Namespace>\<Module>\Model\ResourceModel\<Module>');
    }

}
