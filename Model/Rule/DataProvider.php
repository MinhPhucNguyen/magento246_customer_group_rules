<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Model\Rule;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Tigren\CustomerGroupRule\Model\ResourceModel\Rule\CollectionFactory;

class DataProvider extends AbstractDataProvider
{

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $ruleCollectionFactory,
        array $meta = [],
        array $data = [])
    {
        $this->collection = $ruleCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        $this->loadedData = [];
        foreach ($items as $rule) {
            $this->loadedData[$rule->getId()] = $rule->getData();
        }
        return $this->loadedData;
    }
}
