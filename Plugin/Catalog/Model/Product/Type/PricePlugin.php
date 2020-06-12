<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Plugin\Catalog\Model\Product\Type;

use Magento\Catalog\Model\Product\Type\Price;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator;

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
     * @var Calculator
     */
    private $calculator;

    /**
     * Initialize Plugin
     *
     * @param Calculator $calculator
     * @param PriceHelper $helper
     */
    public function __construct(
        Calculator $calculator,
        PriceHelper $helper
    ) {
        $this->calculator = $calculator;
        $this->helper = $helper;
    }

    /**
     * Get base price with apply Group, Tier, Special prises
     *
     * @param Price $subject
     * @param float|string $price
     * @return float|string
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
