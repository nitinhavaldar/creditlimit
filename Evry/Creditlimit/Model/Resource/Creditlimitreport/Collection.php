<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Model\Resource\Creditlimitreport;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected $_idFieldName = 'report_id'; 

    protected function _construct()
    {
        $this->_init(
            'Evry\Creditlimit\Model\Creditlimitreport',
            'Evry\Creditlimit\Model\Resource\Creditlimitreport'
        );
    }
}