<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Model\Rule;

use Magento\Framework\Data\OptionSourceInterface;

class ProductsProvider implements OptionSourceInterface
{
    public function getProductOptions()
    {

        $productIds = [1, 2, 12];

        $options = [];
        foreach ($productIds as $productId) {
            $productLabel = '';
            $options[] = [
                'label' => $productLabel,
                'value' => $productId,
            ];
        }

        return $options;
    }

    public function toOptionArray()
    {
        return $this->getProductOptions();
    }
}
