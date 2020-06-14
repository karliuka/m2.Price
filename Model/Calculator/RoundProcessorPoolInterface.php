<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator;

/**
 * Price round processor pool interface
 */
interface RoundProcessorPoolInterface
{
    /**
     * Retrieve the round processor
     *
     * @param string $roundType
     * @return RoundProcessorInterface
     */
    public function getProcessor($roundType);
}
