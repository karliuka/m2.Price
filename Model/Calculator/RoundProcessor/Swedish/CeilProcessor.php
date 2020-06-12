<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Swedish;

use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator\RoundProcessorInterface;

/**
 * Swedish Ceil Round Processor
 */
class CeilProcessor implements RoundProcessorInterface
{
    /**
     * Round Price Helper
     *
     * @var PriceHelper
     */
    private $helper;

    /**
     * Swedish Round Fraction
     *
     * @var float
     */
    private $fraction;

    /**
     * Initialize Processor
     *
     * @param PriceHelper $helper
     */
    public function __construct(
        PriceHelper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Retrieve the Rounded Price
     *
     * @param float $price
     * @return float
     */
    public function round($price)
    {
        return ceil($price/$this->getFraction()) * $this->getFraction();
    }

    /**
     * Retrieve Swedish Round Fraction
     *
     * @return float
     */
    private function getFraction()
    {
        if (null === $this->fraction) {
            $this->fraction = $this->helper->getSwedishFraction();
        }
        return $this->fraction;
    }
}
