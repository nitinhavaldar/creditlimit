<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Model\Resource\Creditlimitwallet;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected $_idFieldName = 'wallet_id'; 

    protected function _construct()
    {
        $this->_init(
            'Evry\Creditlimit\Model\Creditlimitwallet',
            'Evry\Creditlimit\Model\Resource\Creditlimitwallet'
        );
    }
}