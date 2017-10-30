<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Model\Resource;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
class Creditlimit extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('credit_limit', 'entity_id');
    }

    
}