<?php
// @Evry India Pvt Ltd
?>

<?php

namespace Evry\Creditlimit\Block\Adminhtml\Creditlimit;

class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Evry_Creditlimit';
        $this->_controller = 'adminhtml_creditlimit';
        $this->_headerText = __('Creditlimit');
        parent::_construct();
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
        
    }


   
}