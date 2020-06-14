<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Excel;

use Faonni\Price\Model\Calculator\RoundProcessorInterface;

/**
 * Excel floor round processor
 */
class FloorProcessor extends AbstractProcessor implements RoundProcessorInterface
{
    /**
     * Retrieve the rounded price
     *
     * @param float $price
     * @return float
     */
    public function round($price)
    {
        return $this->getPrecision() < 0
            ? floor($price/$this->getMultiplier()) * $this->getMultiplier()
            : floor($price * $this->getMultiplier())/$this->getMultiplier();
    }
}
