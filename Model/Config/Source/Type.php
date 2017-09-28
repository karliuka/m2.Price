<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Faonni\Price\Model\Plugin\Currency;

/**
 * Source of option values in a form of value-label pairs
 */
class Type implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
			['value' => Currency::TYPE_CEIL,  'label' => __('Round fractions up')],
			['value' => Currency::TYPE_FLOOR, 'label' => __('Round fractions down')],
			['value' => Currency::TYPE_SWEDISH_CEIL,  'label' => __('Swedish Round up')],
			['value' => Currency::TYPE_SWEDISH_ROUND, 'label' => __('Swedish Round')],
			['value' => Currency::TYPE_SWEDISH_FLOOR, 'label' => __('Swedish Round down')]			
		];
    }
}
