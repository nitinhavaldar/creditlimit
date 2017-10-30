<?php

namespace Evry\Creditlimit\Observer;
 
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Exception\LocalizedException;
use \Magento\Framework\Message\ManagerInterface;
use \Psr\Log\LoggerInterface;
use \Magento\Framework\UrlInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Evry\Creditlimit\Helper\Data;
use Evry\Creditlimit\Block\Creditlimit;

 
class orderSaveAfter implements ObserverInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;
    protected $_logger;
    protected $date;
    protected $_helper;
    protected $_block;
    protected $_exceptionMsg;
    protected $_url;
    protected $_redirectFactory;
 
    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        LoggerInterface $logger,DateTime $date, Data $helper,Creditlimit $block,
        ManagerInterface $exceptionMsg,UrlInterface $url,RedirectFactory $redirectFactory
    ) {
        $this->_objectManager = $objectManager;
        $this->_logger = $logger;
        $this->date = $date;
        $this->_helper=$helper;
        $this->_block = $block;
        $this->_exceptionMsg = $exceptionMsg;
        $this->_url = $url;
        $this->_redirectFactory = $redirectFactory;
    }
 
    /**
     * customer register event handler
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        try {
            
            $order = $observer->getEvent()->getOrder();
            $grand_total = (float)$order->getGrandTotal();
            $payment_method = $order->getPayment()->getMethodInstance()->getTitle();
            $customer_id = $order->getCustomerId();
            $creditLimit = $this->_block->getAvailableLimits($customer_id)->getFirstItem()->getCreditLimit();
            if($payment_method=='Pay On Account') {
               
                 if($grand_total<=$creditLimit) {
                     $amount = $creditLimit - $grand_total;
                     $update = $this->_block->updateCreditLimit($customer_id,$amount);

                     //Store these details into database
                     
                     $usage = ($grand_total / $creditLimit) * 100;
                     $objectManager = \Magento\Framework\App\ObjectManager::getInstance();       
                            $question = $objectManager->create('Evry\Creditlimit\Model\Creditlimitreport');
                            $question->setOrderId($order->getIncrementId());
                            $question->setCustomerId($customer_id);
                            $question->setCustomerEmail($order->getCustomerEmail());
                            $question->setInitialCredits($creditLimit);
                            $question->setUsedCredits($grand_total);
                            $question->setAvailableCredits($amount);
                            $question->setCreditUsage($usage.'%');
                            $question->setCreatedAt($this->_helper->getDate()); 
                            $question->save();
                 }
                 else {
                    throw new \Magento\Framework\Validator\Exception(__('Payment refunding error.'));
                 }
                 
            }

           
                
        } catch(LocalizedException $e) {
                
                $this->_exceptionMsg->addError($e->getMessage());
                die($e->getMessage());
        }

    
        
    }
}