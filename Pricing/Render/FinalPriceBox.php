<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2023 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupRule\Pricing\Render;

use Magento\Catalog\Model\Product\Pricing\Renderer\SalableResolverInterface;
use Magento\Catalog\Pricing\Price\MinimalPriceCalculatorInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Pricing\Price\PriceInterface;
use Magento\Framework\Pricing\Render\RendererPool;
use Magento\Framework\Pricing\SaleableInterface;
use Magento\Framework\View\Element\Template\Context;

class FinalPriceBox extends \Magento\Catalog\Pricing\Render\FinalPriceBox
{
    public function __construct(
        Context                         $context,
        SaleableInterface               $saleableItem,
        PriceInterface                  $price,
        RendererPool                    $rendererPool,
        array                           $data = [],
        SalableResolverInterface        $salableResolver = null,
        MinimalPriceCalculatorInterface $minimalPriceCalculator = null
    )
    {
        parent::__construct($context,
            $saleableItem,
            $price,
            $rendererPool,
            $data,
            $salableResolver,
            $minimalPriceCalculator);
    }

    protected function wrapResult($html)
    {
        $objectManager = ObjectManager::getInstance();
        $httpContext = $objectManager->get('Magento\Framework\App\Http\Context');
        $isLoggedIn = $httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);

        if ($isLoggedIn) {
            return '<div class="price-box price-final_price' . $this->getData('css_classes') . '" ' .
                'data-role="price-box" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $html . '</div>';
        } else {
            $wording = 'Please Login To See Price';
            return '<div class="" ' .
                'data-role="price-box" ' .
                'data-product-id="' . $this->getSaleableItem()->getId() . '"' .
                '>' . $wording . '</div>';
        }
    }
}
