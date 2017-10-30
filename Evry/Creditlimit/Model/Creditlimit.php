<?php
// @Evry India Pvt Ltd 
namespace Evry\Creditlimit\Model;
 
use Magento\Framework\Model\AbstractModel;
 
class Creditlimit extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Evry\Creditlimit\Model\Resource\Creditlimit');
    }
}