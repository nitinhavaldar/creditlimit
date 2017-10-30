<?php
namespace Evry\Creditlimit\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Stdlib\DateTime\DateTime;
use \Magento\Framework\Exception\LocalizedException;
use \Magento\Customer\Model\Session;
use \Magento\Customer\Model\CustomerFactory;
use Evry\Bulkenquiry\Model\BulkenquiryFactory;
use Evry\Bulkenquiry\Block\Bulkenquiry;
use Magento\Framework\Controller\Result\JsonFactory;

class Checkcustomer extends Action
{
    
    protected $_modelBulkenquiryFactory;
    protected $_resultPageFactory;
    protected $date;
    protected $_customerSession;
    protected $_block;
    protected $_jsonFactory;
    protected $_customerModel;
    
    public function __construct(Context $context,
           PageFactory $resultPageFactory,DateTime 
           $date,BulkenquiryFactory $modelBulkenquiryFactory,
           Session $customerSession, 
           Bulkenquiry $block,JsonFactory $jsonFactory,CustomerFactory $customerModel)
    {
        
        parent::__construct($context);
        $this->date = $date;
        $this->block = $block;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_modelBulkenquiryFactory = $modelBulkenquiryFactory;
        $this->_customerSession = $customerSession;
        $this->_customerModel = $customerModel;
        $this->_jsonFactory = $jsonFactory;
        
    }
 
    public function execute()
    {
        
        $email = $this->getRequest()->getPost('email');
        $resultJson = $this->_jsonFactory->create();
        $logged_email = $this->_customerSession->getCustomer()->getEmail();

        try {
          
          if($email==$logged_email) {
            throw new LocalizedException(__('You cannot transfer the limit to yourself'));
            return;
          }

          $customers = $this->_customerModel->create();
          $collection = $customers->getCollection()
                    ->addFieldToFilter('email',array('eq' => $email));
                    
          
          if(count($collection) > 0) { 
             
             $cid = $collection->getFirstItem()->getEntityId();
             $msg = "Congratulations!! Your Buddy is already registered with us. You can transfer the limit";
             $response = ['responseJson' => 'success', 'cid'=>$cid, 'message' => $msg];
          }

            else {

               throw new LocalizedException(__('It seems your Buddy have not registered with our website'));
            }

      } catch (\Exception $e) {
          $response = ['responseJson' => 'exception', 'message' => $e->getMessage()];
      }

      return $resultJson->setData($response);
    }
}