<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Excel;

use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator\RoundProcessorInterface;

/**
 * Excel Ceil Round Processor
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
     * Precision
     *
     * @var int
     */
    private $precision;

    /**
     * Multiplier
     *
     * @var int|float
     */
    private $multiplier;

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
        return $this->getPrecision() < 0
            ? ceil($price/$this->getMultiplier()) * $this->getMultiplier()
            : ceil($price * $this->getMultiplier())/$this->getMultiplier();
    }

    /**
     * Retrieve Precision
     *
     * @return int
     */
    private function getPrecision()
    {
        if (null === $this->precision) {
            $this->precision = $this->helper->getPrecision();
        }
        return $this->precision;
    }

    /**
     * Retrieve Multiplier
     *
     * @return int|float
     */
    private function getMultiplier()
    {
        if (null === $this->multiplier) {
            $this->multiplier = $this->helper->getPrecision();
        }
        return $this->multiplier;
    }
}
