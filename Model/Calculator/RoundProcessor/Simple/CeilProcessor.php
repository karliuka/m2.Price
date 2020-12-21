<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Simple;

use Faonni\Price\Model\Calculator\RoundProcessorInterface;

/**
 * Simple ceil round processor
 */
class CeilProcessor implements RoundProcessorInterface
{
    /**
     * Retrieve the rounded price
     *
     * @param float $price
     * @return float
     */
    public function round($price)
    {
        return ceil($price);
    }
}
