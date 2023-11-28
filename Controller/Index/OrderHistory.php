<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Model\Session as CustomerSession;

class OrderHistory extends Action
{
    protected $pageFactory;
    protected $customerSession;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context         $context,
        PageFactory     $pageFactory,
        CustomerSession $customerSession
    )
    {
        $this->pageFactory = $pageFactory;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        if (!$this->customerSession->isLoggedIn()) {
            // If user is not logged in, redirect to the login page or another page
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/customer/account/login'); // Redirect to login page
            return $resultRedirect;
        }
        return $this->pageFactory->create();
    }
}

