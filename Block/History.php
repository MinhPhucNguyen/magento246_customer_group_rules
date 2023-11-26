<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Block;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Tigren\CustomerGroupRule\Model\OrderHistoryFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session as CustomerSession;

class History extends Template
{
    protected $orderHistoryFactory;

    protected $customerSession;

    /**
     * @param Context $context
     * @param OrderHistoryFactory $orderHistoryFactory
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Context             $context,
        OrderHistoryFactory $orderHistoryFactory,
        CustomerSession     $customerSession
    )
    {
        $this->orderHistoryFactory = $orderHistoryFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return AbstractDb|AbstractCollection|null
     */
    public function getOrderHistoryByCustomerId()
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        $orderCollection = $this->orderHistoryFactory->create()
            ->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->setOrder('history_id', 'DESC');

        return $orderCollection;
    }
}
