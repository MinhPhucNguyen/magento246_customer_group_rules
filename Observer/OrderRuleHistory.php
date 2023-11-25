<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ResourceConnection;
use Tigren\CustomerGroupRule\Model\RuleFactory;
use Tigren\CustomerGroupRule\Model\OrderHistoryFactory;
use Zend_Log;
use Zend_Log_Writer_Stream;


class OrderRuleHistory implements ObserverInterface
{

    protected $resourceCollection;

    protected $ruleFactory;
    protected $orderHistoryFactory;


    public function __construct(
        ResourceConnection  $resourceConnection,
        RuleFactory         $ruleFactory,
        OrderHistoryFactory $orderHistoryFactory
    )
    {
        $this->resourceCollection = $resourceConnection;
        $this->ruleFactory = $ruleFactory;
        $this->orderHistoryFactory = $orderHistoryFactory;
    }

    public function execute(Observer $observer)
    {
        //get Order after place order success
        $order = $observer->getEvent()->getOrder();

        $entityId = $order->getId();
        $orderId = $order->getIncrementId();
        $customerId = $order->getCustomerId();
        $orderHistoryModel = $this->orderHistoryFactory->create();

        $productIds = [];
        foreach ($order->getAllItems() as $item) {
            $productIds[] = $item->getProductId();
        }

        $rules = $this->ruleFactory->create()->getCollection();
        $rules->addFieldToFilter('product_id', ['in' => $productIds]);

        $ruleIds = [];
        foreach ($rules as $rule) {
            $ruleIds[] = $rule->getId();
        }

        foreach ($ruleIds as $ruleId) {
            $orderHistoryModel->addData([
                'entity_id' => $entityId,
                'order_id' => $orderId,
                'rule_id' => $ruleId,
                'customer_id' => $customerId,
            ])->save();
        }
    }
}

