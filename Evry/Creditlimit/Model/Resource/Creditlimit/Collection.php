<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Model\Resource\Creditlimit;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected $_idFieldName = 'entity_id'; 

    protected function _construct()
    {
        $this->_init(
            'Evry\Creditlimit\Model\Creditlimit',
            'Evry\Creditlimit\Model\Resource\Creditlimit'
        );
    }
}