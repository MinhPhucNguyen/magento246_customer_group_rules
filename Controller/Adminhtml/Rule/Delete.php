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
use Magento\Framework\App\Action\HttpPostActionInterface;
use Tigren\CustomerGroupRule\Model\RuleFactory;
use Tigren\CustomerGroupRule\Model\ResourceModel\Rule as RuleResource;

class Delete extends Action implements HttpPostActionInterface
{

    protected $ruleFactory;

    public function __construct(
        Context              $context,
        private RuleResource $resource,
        RuleFactory          $ruleFactory
    )
    {
        $this->ruleFactory = $ruleFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $ruleId = $this->getRequest()->getParam('rule_id');

        $resultPage = $this->resultRedirectFactory->create();

        if (!$ruleId) {
            $this->messageManager->addErrorMessage(__('This rule no longer exists.'));
            return $resultPage->setPath('*/*/');
        }

        $model = $this->ruleFactory->create();

        print_r($ruleId);
        print_r($model->getData());
        exit();

//        try {
//
//        } catch (Throwable $exception) {
//            $this->messageManager->addErrorMessage($exception->getMessage());
//        }

        return $resultPage->setPath('*/*/');
    }
}

