<?php
// @Evry India Pvt Ltd
namespace Evry\Creditlimit\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use \Magento\Sales\Api\Data\OrderInterface;
use \Magento\Store\Model\StoreManagerInterface;
/**
 * Class ProductDataProvider
 */

class Action extends Column 
{

    /** Url path */
    const ROW_EDIT_URL = 'sales/order/view/';
    /** @var UrlInterface */
    protected $_urlBuilder;
    protected $_orderRepository;
    protected $_storeManager;
 
    /**
     * @var string
     */
    private $_editUrl;
 
    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        OrderInterface $orderRepository,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = [],
        $editUrl = self::ROW_EDIT_URL
    ) 
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        $this->_orderRepository = $orderRepository;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
       if (isset($dataSource['data']['items'])) {
        foreach ($dataSource['data']['items'] as & $item) {
            try {
                    if ($order = $this->_orderRepository->loadByIncrementId($item['order_id'])) {
                        $url = $this->_urlBuilder->getUrl($this->_editUrl,['order_id' => $order->getEntityId()]);      
                        $item[$this->getData('name')] = html_entity_decode("<a href=\"$url\" target=\"_blank\">" . $item['order_id'] . "</a>");
                    }
                } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {

                }

            


        }
    }
 
        return $dataSource;
    }

}
