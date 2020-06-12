<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model;

use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator\RoundProcessorPool;

/**
 * Price Calculator
 */
class Calculator
{
    /**
     * Round Price Helper
     *
     * @var PriceHelper
     */
    private $helper;

    /**
     * Round Processor Pool
     *
     * @var RoundProcessorPool
     */
    private $roundProcessorPool;

    /**
     * Initialize Calculator
     *
     * @param RoundProcessorPool $roundProcessorPool
     * @param PriceHelper $helper
     */
    public function __construct(
        RoundProcessorPool $roundProcessorPool,
        PriceHelper $helper
    ) {
        $this->roundProcessorPool = $roundProcessorPool;
        $this->helper = $helper;
    }

    /**
     * Retrieve the Calculated Price
     *
     * @param float $price
     * @return float
     */
    public function calculate($price)
    {
        return $this->format(max(0, $this->subtract($this->round($price))));
    }

    /**
     * Retrieve the Rounded Price
     *
     * @param float $price
     * @return float
     */
    private function round($price)
    {
        $processor = $this->roundProcessorPool->getProcessor(
            $this->helper->getRoundType()
        );
        return $processor->round($price);
    }

    /**
     * Formats a Number as a Price String
     *
     * @param float|int $price
     * @return float
     */
    private function format($price)
    {
        return (float)sprintf('%0.4F', $price);
    }

    /**
     * Retrieve the Price With a Subtracted Amount
     *
     * @param float $price
     * @return float
     */
    private function subtract($price)
    {
        if ($this->helper->isSubtract()) {
            $price = $price - $this->helper->getAmount();
        }
        return $price;
    }
}
