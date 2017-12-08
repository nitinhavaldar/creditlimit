<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Cart;
use Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\Exception\LocalizedException;
use Evry\Creditlimit\Model\CreditlimitFactory; 
use \Magento\Framework\Stdlib\DateTime\DateTime;
use Evry\Creditlimit\Block\Creditlimit;


class Transfer extends Action
{
    
   
    protected $_requestInfo;
    protected $_customerSession;
    protected $_jsonFactory;
    protected $_block;
    protected $_cart;
    protected $_pro;
    protected $_storeManager;
    protected $_date;

    
    
    public function __construct(Context $context,
                                Session $customerSession,
                                CreditlimitFactory $requestInfo,
                                JsonFactory $jsonFactory,
                                Creditlimit $block,
                                Cart $cart,
                                Product $pro,
                                DateTime $date,
                                StoreManagerInterface $storeManager)
    {
        
        parent::__construct($context);
        $this->_block = $block;
        $this->_customerSession = $customerSession;
        $this->_requestInfo = $requestInfo;
        $this->_jsonFactory = $jsonFactory;
        $this->_pro = $pro;
        $this->_cart = $cart;
        $this->_date = $date;
        $this->_storeManager = $storeManager;

       
       


    }
 
    public function execute()
    {
        
      $post = $this->getRequest()->getPostValue();
      $result = [];
      parse_str($post['data'], $result);
      $resultJson = $this->_jsonFactory->create();
      
      try {
         
         //Validation 
          $logged_in_cid = $this->_customerSession->getCustomer()->getId();
          $from_email = $this->_customerSession->getCustomer()->getEmail();
          $actual_credit = $this->_block->getAvailableLimits($logged_in_cid)->getFirstItem()->getCreditLimit();
          $to_email = $result['email'];
          $amount = $result['amount'];
          $cid = $result['cid'];
          $date = $this->_date->gmtDate();

          if($from_email==$to_email) {
            throw new LocalizedException(__("You Cannot transfer limit to yourself"));
            return;
            
          }

          if($amount > $actual_credit) {
            throw new LocalizedException(__("You dont have an enough credits to send."));
            return;
          }

          else {

            //Process 
            $model = $this->_requestInfo->create();
            $collection = $model->getCollection()
                         ->addFieldToFilter('customer_email',array('eq' =>$to_email));
            
            if($collection->getSize()) {
                
                
                //Update the new credit
                $get_credit = $collection->getFirstItem()->getCreditLimit();
                $update_credit = $get_credit + $amount;

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('credit_limit');
                $sql = "UPDATE $tableName SET credit_limit ='$update_credit' WHERE customer_email = '$to_email'";
                $connection->query($sql);

                $sender_limit = $actual_credit - $amount;

                $sql = "UPDATE $tableName SET credit_limit ='$sender_limit' WHERE customer_email = '$from_email'";
                
                $connection->query($sql);
                
                $msg = "$amount has been Credited to your Buddy Account";
                $this->messageManager->addSuccess($msg);
                $response = ['responseJson' => 'success', 'amount' =>$sender_limit, 'message' => $msg];
            }

            else {
                //Insert the data into table
                
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('credit_limit');
                $sql = "INSERT INTO $tableName (enitity_id,customer_id, customer_email, credit_limit, created_at) 
                        VALUES ('','$cid','$to_email','$amount','$date')";
                
                $connection->query($sql);

                $sender_limit = $actual_credit - $amount;

                $sql = "UPDATE $tableName SET credit_limit ='$sender_limit' WHERE customer_email = '$from_email'";
                
                $connection->query($sql);

                $msg = "$amount has been credited to your Buddy Account";
                $this->messageManager->addSuccess($msg);
                $response = ['responseJson' => 'success', 'amount' => $sender_limit, 'message' => $msg];


            }
        }


          
      } catch (\Exception $e) {
          $this->messageManager->addError(__($e->getMessage()));
          $response = ['responseJson' => 'exception', 'message' => $e->getMessage()];
      }
        
        return $resultJson->setData($response);

    }   
}

