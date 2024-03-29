<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Model;

use Magento\Framework\Model\AbstractModel;

class OrderHistory extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(ResourceModel\OrderHistory::class);
    }
}
