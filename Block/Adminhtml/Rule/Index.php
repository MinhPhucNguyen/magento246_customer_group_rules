<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Block\Adminhtml\Rule;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Tigren\CustomerGroupRule\Model\RuleFactory;

class Index extends Template

{
    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @param Context $context
     * @param RuleFactory $ruleFactory
     */
    public function __construct(Context $context, RuleFactory $ruleFactory
    )
    {
        $this->ruleFactory = $ruleFactory;
        parent::__construct($context);
    }

    /**
     * @return AbstractDb|AbstractCollection|null
     */
    public function getAllRules()
    {
        $ruleList = $this->ruleFactory->create();
        return $ruleList->getCollection();
    }
}

