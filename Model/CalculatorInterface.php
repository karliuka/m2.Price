<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * Price calculator interface
 */
interface CalculatorInterface
{
    /**
     * Retrieve the calculated price
     *
     * @param float $price
     * @return float
     */
    public function calculate($price);
}
