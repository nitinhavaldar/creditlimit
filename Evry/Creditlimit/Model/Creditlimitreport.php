<?php
// @Evry India Pvt Ltd 
namespace Evry\Creditlimit\Model;
 
use Magento\Framework\Model\AbstractModel;
 
class Creditlimitreport extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Evry\Creditlimit\Model\Resource\Creditlimitreport');
    }
}