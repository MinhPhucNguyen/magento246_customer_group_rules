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

        $model = $this->ruleFactory->create();

        try {
            if ($data) {
                if (isset($ruleId)) {
                    $model->load($ruleId);
                    $this->handleSetData($model, $data, __('Update rule successfully'
                    ));
                } else {
                    $this->handleSetData($model, $data, __('Create rule successfully'));
                }
            }

        } catch (Exception $e) {
            $this->messageManager->addErrorMessage($e, __('Something went wrong, Please try again'));
        }
        return $resultPage->setPath('*/*/');
    }

    private function handleSetData($model, $data, $message)
    {
        $model->addData([
            'name' => $data['name'],
            'discount_amount' => $data['discount_amount'],
            'from_date' => $data['from_date'],
            'to_date' => $data['to_date'],
            'priority' => $data['priority'],
            'is_active' => $data['is_active'],
            'product_id' => $data['product_id'],
            'store_id' => isset($data['store_id']) ? implode(',', $data['store_id']) : '',
            'customer_group_id' => isset($data['customer_group_id']) ? implode(',', $data['customer_group_id']) : '',
        ])->save();

        $this->messageManager->addSuccessMessage($message);
    }
}


