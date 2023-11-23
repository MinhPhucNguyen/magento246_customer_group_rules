<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Observer;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Tigren\CustomerGroupRule\Model\ResourceModel\Rule\CollectionFactory as RuleCollectionFactory;


class AddToCartAfter implements ObserverInterface
{

    protected $checkoutSession;
    protected $customerSession;
    protected $ruleCollectionFactory;

    /**
     * @param CheckoutSession $checkoutSession
     * @param CustomerSession $customerSession
     * @param RuleCollectionFactory $ruleCollectionFactory
     */
    public function __construct(
        CheckoutSession       $checkoutSession,
        CustomerSession       $customerSession,
        RuleCollectionFactory $ruleCollectionFactory
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }


    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {

        $quoteItem = $observer->getEvent()->getData('quote_item');
        $product = $observer->getEvent()->getData('product');

        if ($this->customerSession->isLoggedIn()) {

            $customerGroupId = $this->customerSession->getCustomerGroupId();

            $specialDiscount = $product->getSpecialDiscount();
            if ($specialDiscount && $specialDiscount > 0) {
                $priceWithSpecialDiscount = $product->getFinalPrice() - ($product->getFinalPrice() * ($specialDiscount / 100));
                $quoteItem->setCustomPrice($priceWithSpecialDiscount);
                $quoteItem->setOriginalCustomPrice($priceWithSpecialDiscount);
                $quoteItem->getProduct()->setIsSuperMode(true);
            } else {
                $ruleCollection = $this->ruleCollectionFactory->create();
                $ruleCollection->addFieldToFilter('is_active', 1)->addFieldToFilter('customer_group_id', $customerGroupId)->setPageSize(1)->load();
                $rule = $ruleCollection->getFirstItem();

                if ($rule->getId()) {
                    $discountAmount = $rule->getDiscountAmount();
                    $quoteItem->setCustomPrice($product->getFinalPrice() - $discountAmount);
                    $quoteItem->setOriginalCustomPrice($product->getFinalPrice() - $discountAmount);
                    $quoteItem->getProduct()->setIsSuperMode(true);
                }
            }
        }
    }
}


