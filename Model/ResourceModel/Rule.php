<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Rule extends AbstractDb
{

    public function getStoreIds($ruleId)
    {
        $result = $this->getConnection()->select()->from(['main_table' => $this->getMainTable()])->where('rule_id = ?', $ruleId);
        $data = $this->getConnection()->fetchAll($result);
        $data = reset($data);
        if (isset($data['store_id'])) {
            return explode(',', $data['store_id']);
        }
    }

    public function filterData($data)
    {
        $datas = [];
        foreach ($data as $item) {
            if (array_key_exists('store_id', $item)) {
                $datas[] = $item['store_id'];
            }
        }
        return $datas;
    }

    protected function _construct()
    {
        $this->_init('tigren_customer_group_catalog_rules', 'rule_id');
    }
}
