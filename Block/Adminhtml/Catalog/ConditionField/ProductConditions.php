<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\CustomerGroupRule\Block\Adminhtml\Catalog\ConditionField;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Renderer\Fieldset;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Rule\Block\Conditions;
use Magento\Rule\Model\Condition\AbstractCondition;
use Magento\Framework\App\ObjectManager;

class ProductConditions extends Generic implements TabInterface
{

    protected $nameInLayout = 'conditions';
    protected $rendererFieldset;
    protected $conditions;


    private $ruleFactory;

    public function __construct(
        Context     $context,
        Registry    $registry,
        FormFactory $formFactory,
        Conditions  $conditions,
        Fieldset    $rendererFieldset,
        array       $data = [],
    )
    {
        $this->rendererFieldset = $rendererFieldset;
        $this->_conditions = $conditions;
        parent::__construct($context, $registry, $formFactory, $data);
    }


    private function getRuleFactory()
    {
        if ($this->ruleFactory === null) {
            $this->ruleFactory = ObjectManager::getInstance()->get('Tigren\CustomerGroupRule\Model\Rule');
        }
        return $this->ruleFactory;
    }

    public function getTabClass()
    {
        return null;
    }

    public function getTabUrl()
    {
        return null;
    }

    public function isAjaxLoaded()
    {
        return false;
    }

    public function getTabLabel()
    {
        return __('Conditions');
    }

    public function getTabTitle()
    {
        return __('Conditions');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_promo_catalog_rule');
        $form = $this->addTabToForm($model);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    protected function addTabToForm(
        $model,
        $fieldsetId = 'product_conditions_serialized',
        $formName = 'custom_condition_form'
    )
    {
        if (!$model) {
            $id = $this->getRequest()->getParam('rule_id');
            $model = $this->getRuleFactory()->create();
            $model->load($id);
        }
        $conditionsFieldSetId = $model->getConditionsFieldSetId($formName);
        $newChildUrl = $this->getUrl(
            'catalog_rule/promo_catalog/newConditionHtml/form/' . $conditionsFieldSetId,
            ['form_namespace' => $formName]
        );

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('rule_');
        $renderer = $this->_rendererFieldset->setTemplate(
            'Magento_CatalogRule::promo/fieldset.phtml'
        )->setNewChildUrl(
            $newChildUrl
        )->setFieldSetId(
            $conditionsFieldSetId
        );

        $fieldset = $form->addFieldset(
            $fieldsetId,
            [
                'legend' => __(
                    'Apply the rule only if the following conditions are met (leave blank for all products).'
                ),
            ]
        )->setRenderer(
            $renderer
        );
        $fieldset->addField(
            'conditions',
            'text',
            [
                'name' => 'conditions',
                'label' => __('Conditions'),
                'title' => __('Conditions'),
                'required' => true,
                'data-form-part' => $formName,
            ]
        )->setRule(
            $model
        )->setRenderer(
            $this->_conditions
        );
        $form->setValues($model->getData());
        $this->setConditionFormName($model->getConditions(), $formName);
        return $form;
    }

    private function setConditionFormName(AbstractCondition $conditions, $formName)
    {
        $conditions->setFormName($formName);
        if ($conditions->getConditions() && is_array($conditions->getConditions())) {
            foreach ($conditions->getConditions() as $condition) {
                $this->setConditionFormName($condition, $formName);
            }
        }
    }
}
