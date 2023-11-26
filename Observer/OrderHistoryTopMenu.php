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
use Magento\Framework\Data\Tree\Node;
use Magento\Customer\Model\Session as CustomerSession;

class OrderHistoryTopMenu implements ObserverInterface
{

    protected $customerSession;

    public function __construct(CustomerSession $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    public function execute(Observer $observer)
    {
        $menu = $observer->getMenu();
        $tree = $menu->getTree();

        $data = [
            'name' => __('Order History'),
            'id' => 'orderhistory',
            'url' => 'customergrouprule/index/orderhistory',
            'is_active' => false
        ];

        $node = new Node($data, 'id', $tree, $menu);
        $menu->addChild($node);
        return $this;
    }

}
