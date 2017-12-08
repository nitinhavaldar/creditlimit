<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Helper;
use \Magento\Framework\Stdlib\DateTime\DateTime;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {

   protected $scopeConfig;
   protected $_date;
   protected $_storeManager;

   const XML_PATH_MODULE_ENABLE = 'credit_limit/creditlimit_settings/enable';
   const XML_PATH_CREDIT_AMOUNT = 'credit_limit/creditlimit_settings/limit';  

   public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
							   \Magento\Store\Model\StoreManagerInterface $storeManager,
								DateTime $date)
   {
      $this->scopeConfig = $scopeConfig;
	   $this->_storeManager = $storeManager;
      $this->_date = $date;
   }
   
   public function getBaseUrl() {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

   public function isEnabled() {
        return $this->scopeConfig
                ->getValue(self::XML_PATH_MODULE_ENABLE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

   public function getCreditLimit() {
        return $this->scopeConfig
                ->getValue(self::XML_PATH_CREDIT_AMOUNT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getDate() {
      return $this->_date->gmtDate();
    }
}
