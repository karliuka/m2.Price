<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator;

/**
 * Price Round Processor Interface
 */
interface RoundProcessorInterface
{
    /**
     * Retrieve the Rounded Price
     *
     * @param float $price
     * @return float
     */
    public function round($price);
}
