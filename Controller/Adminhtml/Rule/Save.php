<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\CustomerGroupRule\Controller\Adminhtml\Rule;

use Laminas\ReCaptcha\Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;
use Tigren\CustomerGroupRule\Model\RuleFactory;

class Save extends Action
{
    protected $pageFactory = false;
    protected $ruleFactory;
    protected $formKeyValidator;

    public function __construct(Context $context, PageFactory $pageFactory, RuleFactory $ruleFactory, Validator $formKeyValidator)
    {
        $this->pageFactory = $pageFactory;
        $this->ruleFactory = $ruleFactory;
        $this->formKeyValidator = $formKeyValidator;
        parent::__construct($context);
    }

    public function execute()
    {

        $resultPage = $this->resultRedirectFactory->create();
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage(__('Form key is invalidate'));
            return $resultPage->setPath('*/*/');
        }

        $data = $this->getRequest()->getPostValue();

        $ruleId = $this->getRequest()->getParam('rule_id');

        try {
            if ($data) {
                $model = $this->ruleFactory->create();
                $model->setData('name', $data['name']);
                $model->setData('discount_amount', $data['discount_amount']);
                $model->setData('from_date', $data['from_date']);
                $model->setData('to_date', $data['to_date']);
                $model->setData('priority', $data['priority']);

                if (isset($data['store_id'])) {
                    $storeIds = serialize($data['store_id']);
                    $model->setData('store_id', $storeIds);
                }

                if (isset($data['customer_group_id'])) {
                    $customerGroupIdsString = serialize($data['customer_group_id']);
                    $model->setData('customer_group_id', $customerGroupIdsString);
                }

                if (isset($data['data']['products'])) {
                    $productIds = serialize($data['data']['products']);
                    $model->setData('product_id', $productIds);
                }

                $model->save();

                $this->messageManager->addSuccessMessage('Create New Rule Successfully');

            }

        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e, __('Something went wrong, Please try again'));
        }
        return $resultPage->setPath('*/*/');
    }
}
