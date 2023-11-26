<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Block;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Tigren\CustomerGroupRule\Model\OrderHistoryFactory;
use Tigren\CustomerGroupRule\Model\RuleFactory;

class RuleAppliedOrder extends Template
{
    protected $customerSession;

    protected $orderHistoryFactory;

    protected $orderCollectionFactory;

    protected $ruleFactory;

    public function __construct(
        Context                $context,
        OrderHistoryFactory    $orderHistoryFactory,
        CustomerSession        $customerSession,
        OrderCollectionFactory $orderCollectionFactory,
        RuleFactory            $ruleFactory
    )
    {
        $this->ruleFactory = $ruleFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->orderHistoryFactory = $orderHistoryFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function getRulesAppliedForOrders()
    {
        $customerId = $this->customerSession->getCustomer()->getId();

        //Get state show rule
        $showRule = $this->customerSession->getCustomer()->getShowRule();

        if (!$showRule === 1) {
            return;
        }

        $orderCollection = $this->orderCollectionFactory->create();
        $ruleCollection = $this->ruleFactory->create()->getCollection();

        $historyCollection = $this->orderHistoryFactory->create()->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->setOrder('order_at', 'DESC'); // Assuming 'order_at' is the order creation timestamp

        $ordersWithRules = [];
        foreach ($historyCollection as $history) {
//            print_r($history->getData());
//            exit();

            $ruleName = $this->ruleFactory->create()->load($history->getRuleId())->getName();

            $ordersWithRules[] = [
                'order_id' => $history->getOrderId(),
                'rule_id' => $history->getRuleId(),
                'rule_name' => $ruleName,
                'created_at' => $history->getOrderAt(),
            ];
        }

        return $ordersWithRules;
    }

}
