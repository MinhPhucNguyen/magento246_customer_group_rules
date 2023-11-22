<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Ui\Component\Listing\Column\Rule;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Store\Model\StoreManagerInterface;
use Tigren\CustomerGroupRule\Model\RuleFactory;

class StoreView extends Column
{
    protected $storeManager;
    protected $storeKey;

    protected $escaper;


    public function __construct(
        ContextInterface      $context,
        UiComponentFactory    $uiComponentFactory,
        StoreManagerInterface $storeManager,
        private RuleFactory   $ruleFactory,
        private SystemStore   $systemStore,
        Escaper               $escaper,
        array                 $components = [],
        array                 $data = [],
                              $storeKey = 'store_id',
    )
    {
        $this->storeManager = $storeManager;
        $this->storeKey = $storeKey;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    protected function prepareItem(array $item)
    {
        $origStores = [];
        $content = '';
        if (!empty($item[$this->storeKey])) {
            $origStores = $this->ruleFactory->create()->getResource()->getStoreIds($item['rule_id']);
        }

        if (!is_array($origStores)) {
//            $origStores = explode(',', $origStores);
            $origStores = [$origStores];
        }
        if (in_array(0, $origStores) && count($origStores) == 1) {
            return __('All Store Views');
        }

        $data = $this->systemStore->getStoresStructure(false, $origStores);

        foreach ($data as $website) {
            $content .= $website['label'] . "<br/>";
            foreach ($website['children'] as $group) {
                $content .= str_repeat('&nbsp;', 3) . $this->escaper->escapeHtml($group['label']) . "<br/>";
                foreach ($group['children'] as $store) {
                    $content .= str_repeat('&nbsp;', 6) . $this->escaper->escapeHtml($store['label']) . "<br/>";
                }
            }
        }

        return $content;
    }


    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }
        return $dataSource;
    }
}
