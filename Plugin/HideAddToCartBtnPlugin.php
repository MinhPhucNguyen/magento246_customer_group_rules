<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Plugin;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Catalog\Model\Product;

class HideAddToCartBtnPlugin
{
    protected $customerSession;

    public function __construct(
        CustomerSession $customerSession,
    )
    {
        $this->customerSession = $customerSession;
    }

    public function afterIsSaleable(Product $subject)
    {
        if (!$this->customerSession->isLoggedIn()) {
            return [];
        }
        return $subject;
    }
}


