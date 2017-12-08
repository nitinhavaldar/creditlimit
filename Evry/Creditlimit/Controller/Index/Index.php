<?php
namespace Evry\Creditlimit\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Stdlib\DateTime\DateTime;
use \Magento\Framework\Exception\LocalizedException;
use \Magento\Customer\Model\Session;


class Index extends Action
{
    protected $_resultPageFactory;
    protected $date;
    protected $_customerSession;
    
    public function __construct(Context $context,
           PageFactory $resultPageFactory,DateTime 
           $date,Session $customerSession)
    {
        
        parent::__construct($context);
        $this->date = $date;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_customerSession = $customerSession;
        
    }
 
    public function execute()
    {
        
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
