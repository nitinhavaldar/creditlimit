<?php
 
namespace Evry\Payonaccount\Model;


/**
 * Pay In Store payment method model
 */
class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
 
    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'payonaccount';
 	
 	public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote =null)
    {
    
    	$obj = \Magento\Framework\App\ObjectManager::getInstance(); 
		$limitCollection = $obj->create('Evry\Creditlimit\Model\Resource\Creditlimit\Collection');
		
		if($limitCollection->getSize()) {
    		$limit = intval($limitCollection->getFirstItem()->getCreditLimit());
    	} 

    	else {
    		$limit = 0;
    	}

    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('Magento\Checkout\Model\Cart');
        $scopeConfig = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface');


    	if (isset($cart)) {
            $grandTotal = $cart->getQuote()->getGrandTotal();
            if (!empty($grandTotal)) {
                
                if ($grandTotal > $limit) { 
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
        return true;
    }
}