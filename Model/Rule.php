<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\CustomerGroupRule\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Tigren\CustomerGroupRule\Api\Data\RuleInterface;

class Rule extends AbstractModel
{

    const CACHE_TAG = 'tigren_customergrouprule_rule';

    public function _construct()
    {
        $this->_init('Tigren\CustomerGroupRule\Model\ResourceModel\Rule');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

//    public function getRuleId()
//    {
//        return $this->getData(self::RULE_ID);
//    }
//
//    public function setRuleId($ruleId)
//    {
//        return $this->setData(self::RULE_ID, $ruleId);
//    }
//
//    public function getName()
//    {
//        return $this->getData(self::NAME);
//    }
//
//    public function setName($name)
//    {
//        return $this->setData(self::NAME, $name);
//    }
//
//    public function getIsActive()
//    {
//        return $this->getData(self::IS_ACTIVE);
//    }
//
//    public function setIsActive($isActive)
//    {
//        return $this->setData(self::IS_ACTIVE, $isActive);
//    }
//
//    public function getDiscountAmount()
//    {
//        return $this->getData(self::DISCOUNT_AMOUNT);
//    }
//
//    public function setDiscountAmount($discountAmount)
//    {
//        return $this->setData(self::DISCOUNT_AMOUNT, $discountAmount);
//    }
//
//    public function getFromDate()
//    {
//        return $this->getData(self::FROM_DATE);
//    }
//
//    public function setFromDate($fromDate)
//    {
//        return $this->setData(self::FROM_DATE, $fromDate);
//    }
//
//    public function getToDate()
//    {
//        return $this->getData(self::TO_DATE);
//    }
//
//    public function setToDate($toDate)
//    {
//        return $this->setData(self::TO_DATE, $toDate);
//    }
//
//    public function getPriority()
//    {
//        return $this->getData(self::PRIORITY);
//    }
//
//    public function setPriority($priority)
//    {
//        return $this->setData(self::PRIORITY, $priority);
//    }
//
//    public function getStoreId()
//    {
//        return $this->getData(self::STORE_ID);
//    }
//
//    public function setStoreId($storeId)
//    {
//        return $this->setData(self::STORE_ID, $storeId);
//    }
}
