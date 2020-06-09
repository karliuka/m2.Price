<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Plugin\Catalog\Model\Product\Type;

use Magento\Catalog\Model\Product\Type\Price;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Math;

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
    protected $helper;

    /**
     * Math Processor
     *
     * @var Math
     */
    protected $math;

    /**
     * Initialize Plugin
     *
     * @param Math $math
     * @param PriceHelper $helper
     */
    public function __construct(
        Math $math,
        PriceHelper $helper
    ) {
        $this->math = $math;
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
            $price = $this->round($price);
            $price = $this->subtract($price);
        }
        return $price;
    }

    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @return bool
     */
    public function isRoundEnabled()
    {
        if (!$this->helper->isEnabled()) {
            return false;
        }
        if (!$this->helper->isRoundingBasePrice()) {
            return false;
        }
        return true;
    }

    /**
     * Formats a Number as a Currency String
     *
     * @param float $price
     * @return float
     */
    protected function format($price)
    {
        return (float)sprintf('%0.4F', $price);
    }

    /**
     * Retrieve the Price With a Subtracted Amount
     *
     * @param float $price
     * @return float|string
     */
    protected function subtract($price)
    {
        if ($this->helper->isSubtract()) {
            $price = $price - $this->helper->getAmount();
        }
        return (0 < $price)
            ? $price
            : $this->format(0);
    }

    /**
     * Retrieve the Rounded Price
     *
     * @param float $price
     * @return float
     */
    protected function round($price)
    {
        return $this->format(
            $this->math->round($price)
        );
    }
}
