<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model\Calculator;

use Magento\Framework\Exception\LocalizedException;

/**
 * Round Processor Pool
 */
class RoundProcessorPool
{
    /**
     * Round Processors
     *
     * @var RoundProcessorInterface[]
     */
    private $processors;

    /**
     * Initialize Pool
     *
     * @param RoundProcessorInterface[] $processors
     */
    public function __construct(
        array $processors = []
    ) {
        foreach ($processors as $processor) {
            if (!$processor instanceof RoundProcessorInterface) {
                throw new LocalizedException(
                    __('Round Processor must implement %1.', RoundProcessorInterface::class)
                );
            }
        }
        $this->processors = $processors;
    }

    /**
     * Retrieve the Round Processor
     *
     * @param string $roundType
     * @return RoundProcessorInterface
     */
    public function getProcessor($roundType)
    {
        if (!isset($this->processors[$roundType])) {
            throw new LocalizedException(
                __('There is no Round Processor registered for type %1.', $roundType)
            );
        }
        return $this->processors[$roundType];
    }
}
