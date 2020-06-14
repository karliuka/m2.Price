<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model;

use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator\RoundProcessorPoolInterface;

/**
 * Price calculator
 */
class Calculator implements CalculatorInterface
{
    /**
     * Round price helper
     *
     * @var PriceHelper
     */
    private $helper;

    /**
     * Round processor pool
     *
     * @var RoundProcessorPoolInterface
     */
    private $roundProcessorPool;

    /**
     * Initialize calculator
     *
     * @param RoundProcessorPoolInterface $roundProcessorPool
     * @param PriceHelper $helper
     */
    public function __construct(
        RoundProcessorPoolInterface $roundProcessorPool,
        PriceHelper $helper
    ) {
        $this->roundProcessorPool = $roundProcessorPool;
        $this->helper = $helper;
    }

    /**
     * Retrieve the calculated price
     *
     * @param float $price
     * @return float
     */
    public function calculate($price)
    {
        return $this->format(max(0, $this->subtract($this->round($price))));
    }

    /**
     * Retrieve the rounded price
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
     * Formats a number as a price string
     *
     * @param float|int $price
     * @return float
     */
    private function format($price)
    {
        return (float)sprintf('%0.4F', $price);
    }

    /**
     * Retrieve the price with a subtracted amount
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
