<?php

namespace <Namespace>\<Module>\Model\ResourceModel;

/**
 * <Module> Resource Model
 */
class <Module> extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('<namespace>_<module>', '<module>_id');
    }
}
