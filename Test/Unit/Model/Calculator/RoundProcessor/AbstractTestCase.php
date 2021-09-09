<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Test\Unit\Model\Calculator\RoundProcessor;

use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Faonni\Price\Model\Calculator\RoundProcessorInterface;
use Faonni\Price\Helper\Data as PriceHelper;

/**
 * Abstract test processor
 */
class AbstractTestCase extends TestCase
{
    /**
     * @var RoundProcessorInterface
     */
    protected $processor;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $helper;

    /**
     * Prepare test
     *
     * @param string $className
     * @return void
     */
    protected function prepare(string $className)
    {
        $this->helper = $this->getMockBuilder(PriceHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $objectManager = new ObjectManager($this);
        /** @var RoundProcessorInterface $processor */
        $processor = $objectManager->getObject(
            $className,
            ['helper' => $this->helper]
        );

        $this->processor = $processor;
    }
}
