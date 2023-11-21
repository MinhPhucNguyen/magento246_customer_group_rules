<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\CustomerGroupRule\Model;

use Magento\Framework\Model\AbstractModel;
use Tigren\CustomerGroupCatalog\Api\Data\RuleInterface;

class Rule extends AbstractModel
{
    public function _construct()
    {
        $this->_init('Tigren\CustomerGroupRule\Model\ResourceModel\Rule');
    }

//    public function getCustomerGroupId()
//    {
//        return $this->getData('customer_group_id');
//    }
//
//    public function getStoreId()
//    {
//        return $this->getData('store_id');
//    }
//
//    public function getProductId()
//    {
//        return $this->getData('product_id');
//    }
}
