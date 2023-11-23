<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\CustomerGroupRule\Model;

use Magento\CatalogRule\Model\Rule\Action\CollectionFactory;
use Magento\CatalogRule\Model\Rule\Condition\CombineFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Rule\Model\AbstractModel;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Tigren\CustomerGroupRule\Api\Data\RuleInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Rule extends AbstractModel implements RuleInterface, IdentityInterface
{

    const CACHE_TAG = 'tigren_customergrouprule_rule';

    /**
     * @var CombineFactory
     */
    protected $condCombineFactory;

    /**
     * @var CollectionFactory
     */
    protected $condProdCombineF;

    public function __construct(
        CollectionFactory          $condProdCombineF,
        CombineFactory             $condCombineFactory,
        Context                    $context,
        Registry                   $registry,
        FormFactory                $formFactory,
        TimezoneInterface          $localeDate,
        AbstractResource           $resource = null,
        AbstractDb                 $resourceCollection = null,
        array                      $data = [],
        ExtensionAttributesFactory $extensionFactory = null,
        AttributeValueFactory      $customAttributeFactory = null,
        Json                       $serializer = null)
    {
        $this->condProdCombineF = $condProdCombineF;
        $this->condCombineFactory = $condCombineFactory;
        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data, $extensionFactory, $customAttributeFactory, $serializer);
    }

    public function _construct()
    {
        $this->_init('Tigren\CustomerGroupRule\Model\ResourceModel\Rule');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @param $formName
     * @return string
     */
    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    /**
     * @return Combine|Combine
     */
    public function getConditionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    /**
     * @return Collection|Collection
     */
    public function getActionsInstance()
    {
        return $this->condProdCombineF->create();
    }

    public function getRuleId()
    {
        return $this->getData(self::RULE_ID);
    }

    public function setRuleId($ruleId)
    {
        return $this->setData(self::RULE_ID, $ruleId);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function getDiscountAmount()
    {
        return $this->getData(self::DISCOUNT_AMOUNT);
    }

    public function setDiscountAmount($discountAmount)
    {
        return $this->setData(self::DISCOUNT_AMOUNT, $discountAmount);
    }

    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    public function setFromDate($fromDate)
    {
        return $this->setData(self::FROM_DATE, $fromDate);
    }

    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    public function setToDate($toDate)
    {
        return $this->setData(self::TO_DATE, $toDate);
    }

    public function getPriority()
    {
        return $this->getData(self::PRIORITY);
    }

    public function setPriority($priority)
    {
        return $this->setData(self::PRIORITY, $priority);
    }

    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }
}
