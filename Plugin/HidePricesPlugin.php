<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Plugin;

use Magento\Catalog\Block\Product\ListProduct;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\UrlInterface;

class HidePricesPlugin
{
    protected $customerSession;
    protected $urlBuilder;

    public function __construct(
        CustomerSession $customerSession,
        UrlInterface    $urlBuilder
    )
    {
        $this->customerSession = $customerSession;
        $this->urlBuilder = $urlBuilder;
    }

    public function afterGetProductPrice(ListProduct $subject, $result)
    {

        if (!$this->customerSession->isLoggedIn()) {
            $loginUrl = $this->urlBuilder->getUrl('customer/account/login');
            return '<a href="' . $loginUrl . '">Login to see the price</a>';
        }
        return $result;
    }
}

