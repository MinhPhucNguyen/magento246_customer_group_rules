<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */


namespace Tigren\CustomerGroupRule\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\View\Result\PageFactory;

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

        echo "%%%%";
        exit();
//        $resultPage = $this->resultRedirectFactory->create();
//        if (!$this->formKeyValidator->validate($this->getRequest())) {
//            $this->messageManager->addErrorMessage(__('Form key is invalidate'));
//            return $resultPage->setPath('*/*/');
//        }
//
//        $data = $this->getRequest()->getPostValue();
//
//        $categoryId = $this->getRequest()->getParam('rule_id');
//
//        print_r($data);
//        print_r($categoryId);
//        exit();
//        return $resultPage->setPath('*/*/');
    }
}
