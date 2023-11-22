<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Ui\Component\Listing\Column\Rule;

use Tigren\CustomerGroupRule\Model\Rule;
use Magento\Framework\Data\OptionSourceInterface;

class IsActive implements OptionSourceInterface
{
    /**
     * @var Page
     */
    protected $rulePage;

    /**
     * Constructor
     *
     * @param Rule $rulePage
     */
    public function __construct(Rule $rulePage)
    {
        $this->rulePage = $rulePage;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->rulePage->getStoreId();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
