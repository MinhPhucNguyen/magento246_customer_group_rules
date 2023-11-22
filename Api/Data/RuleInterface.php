<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Api\Data;

interface RuleInterface
{
    const RULE_ID = 'rule_id';
    const NAME = 'name';
    const IS_ACTIVE = 'is_active';
    const DISCOUNT_AMOUNT = 'discount_amount';
    const FROM_DATE = 'from_date';
    const TO_DATE = 'to_date';
    const PRIORITY = 'priority';

    const STORE_ID = 'store_id';

    public function getRuleId();

    public function setRuleId($ruleId);

    public function getName();

    public function setName($name);

    public function getIsActive();

    public function setIsActive($isActive);

    public function getDiscountAmount();

    public function setDiscountAmount($discountAmount);

    public function getFromDate();

    public function setFromDate($fromDate);

    public function getToDate();

    public function setToDate($toDate);

    public function getPriority();

    public function setPriority($priority);

    public function getStoreId();

    public function setStoreId($storeId);
}
