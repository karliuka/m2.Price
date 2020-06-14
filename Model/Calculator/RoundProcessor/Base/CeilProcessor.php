<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Base;

use Faonni\Price\Model\Calculator\RoundProcessorInterface;

/**
 * Base ceil round processor
 */
class CeilProcessor extends AbstractProcessor implements RoundProcessorInterface
{
    /**
     * Retrieve the rounded price
     *
     * @param float $price
     * @return float
     */
    public function round($price)
    {
        return round($price, $this->getPrecision(), PHP_ROUND_HALF_UP);
    }
}
