<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator\RoundProcessor\Swedish;

use Faonni\Price\Helper\Data as PriceHelper;

/**
 * Swedish abstract round processor
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
     * Swedish round fraction
     *
     * @var float
     */
    private $fraction;

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
     * Retrieve swedish round fraction
     *
     * @return float
     */
    protected function getFraction()
    {
        if (null === $this->fraction) {
            $this->fraction = $this->helper->getSwedishFraction();
        }
        return $this->fraction;
    }
}
