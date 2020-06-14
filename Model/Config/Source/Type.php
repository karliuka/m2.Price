<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Round type source option
 */
class Type implements ArrayInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return mixed[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'ceil',  'label' => __('Round fractions up')],
            ['value' => 'floor', 'label' => __('Round fractions down')],
            ['value' => 'swedish_ceil',  'label' => __('Swedish Round up')],
            ['value' => 'swedish_round', 'label' => __('Swedish Round')],
            ['value' => 'swedish_floor', 'label' => __('Swedish Round down')],
            ['value' => 'excel_ceil',  'label' => __('Excel Round up')],
            ['value' => 'excel_round', 'label' => __('Excel Round')],
            ['value' => 'excel_floor', 'label' => __('Excel Round down')]
        ];
    }
}
