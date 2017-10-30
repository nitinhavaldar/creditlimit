<?php
namespace Evry\Creditlimit\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Stdlib\DateTime\DateTime;
use \Magento\Framework\Exception\LocalizedException;
use \Magento\Customer\Model\Session;
use Evry\Bulkenquiry\Model\BulkenquiryFactory;
use Evry\Bulkenquiry\Block\Bulkenquiry;

class Index extends Action
{
    
    protected $_modelBulkenquiryFactory;
    protected $_resultPageFactory;
    protected $date;
    protected $_customerSession;
    protected $_block;
    
    public function __construct(Context $context,
           PageFactory $resultPageFactory,DateTime 
           $date,BulkenquiryFactory $modelBulkenquiryFactory,
           Session $customerSession, 
           Bulkenquiry $block)
    {
        
        parent::__construct($context);
        $this->date = $date;
        $this->block = $block;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_modelBulkenquiryFactory = $modelBulkenquiryFactory;
        $this->_customerSession = $customerSession;
        
    }
 
    public function execute()
    {
        
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}