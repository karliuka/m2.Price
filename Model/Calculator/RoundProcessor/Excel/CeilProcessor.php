<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Excel;

use Faonni\Price\Model\Calculator\RoundProcessorInterface;

/**
 * Excel ceil round processor
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
        return $this->getPrecision() < 0
            ? ceil($price/$this->getMultiplier()) * $this->getMultiplier()
            : ceil($price * $this->getMultiplier())/$this->getMultiplier();
    }
}
