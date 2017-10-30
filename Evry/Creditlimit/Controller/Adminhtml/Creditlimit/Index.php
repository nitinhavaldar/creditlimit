<?php
// @Evry India Pvt Ltd
?>
<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Evry\Creditlimit\Controller\Adminhtml\Creditlimit;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Evry\Creditlimit\Controller\Adminhtml\Creditlimit
{
        
        public function execute()
        {  
            $resultPage = $this->_initAction();
            $resultPage->getConfig()->getTitle()->prepend(__('Credit Limits Usage'));
            return $resultPage;
        }

        protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Evry_Creditlimit::grid_list');
    }
}