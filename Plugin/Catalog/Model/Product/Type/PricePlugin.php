<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Plugin\Catalog\Model\Product\Type;

use Magento\Catalog\Model\Product\Type\Price;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\CalculatorInterface;

/**
 * Currency Price Plugin
 */
class PricePlugin
{
    /**
     * Round Price Helper
     *
     * @var PriceHelper
     */
    private $helper;

    /**
     * Price Calculator
     *
     * @var CalculatorInterface
     */
    private $calculator;

    /**
     * Initialize Plugin
     *
     * @param CalculatorInterface $calculator
     * @param PriceHelper $helper
     */
    public function __construct(
        CalculatorInterface $calculator,
        PriceHelper $helper
    ) {
        $this->calculator = $calculator;
        $this->helper = $helper;
    }

    /**
     * Get base price with apply Group, Tier, Special prises
     *
     * @param Price $subject
     * @param float $price
     * @return float
     */
    public function afterGetBasePrice(
        Price $subject,
        $price
    ) {
        if ($this->isRoundEnabled()) {
            $price = $this->calculator->calculate($price);
        }
        return $price;
    }

    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @return bool
     */
    private function isRoundEnabled()
    {
        return $this->helper->isEnabled() && $this->helper->isRoundingBasePrice();
    }
}
