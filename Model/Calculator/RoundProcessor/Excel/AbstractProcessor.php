<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Excel;

use Faonni\Price\Helper\Data as PriceHelper;

/**
 * Excel abstract round processor
 */
abstract class AbstractProcessor
{
    /**
     * Round price helper
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
     * Initialize processor
     *
     * @param PriceHelper $helper
     */
    public function __construct(
        PriceHelper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Retrieve precision
     *
     * @return int
     */
    protected function getPrecision()
    {
        if (null === $this->precision) {
            $this->precision = $this->helper->getPrecision();
        }
        return $this->precision;
    }

    /**
     * Retrieve multiplier
     *
     * @return int|float
     */
    protected function getMultiplier()
    {
        if (null === $this->multiplier) {
            $this->multiplier = pow(10, abs($this->getPrecision()));
        }
        return $this->multiplier;
    }
}
