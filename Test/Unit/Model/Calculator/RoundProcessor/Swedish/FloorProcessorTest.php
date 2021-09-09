<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Test\Unit\Model\Calculator\RoundProcessor\Swedish;

use Faonni\Price\Test\Unit\Model\Calculator\RoundProcessor\AbstractTestCase;
use Faonni\Price\Model\Calculator\RoundProcessor\Swedish\FloorProcessor as Processor;

/**
 * Test swedish floor processor
 */
class FloorProcessorTest extends AbstractTestCase
{
    /**
     * Prepare test
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->prepare(Processor::class);
    }

    /**
     * Test round price
     *
     * @param float $fraction
     * @param float $price
     * @param string $result
     * @return void
     * @dataProvider dataProviderRound
     * @test
     */
    public function testRound($fraction, $price, $result)
    {
        $this->helper->expects($this->once())
            ->method('getSwedishFraction')
            ->willReturn($fraction);

        $this->assertEquals($result, $this->processor->round($price));
    }

    /**
     * Data provider of round price test
     *
     * @return mixed[]
     */
    public function dataProviderRound()
    {
        return [
            [0.05, 3.40, 3.40],
            [0.05, 3.41, 3.40],
            [0.05, 3.44, 3.40],
            [0.05, 3.45, 3.45],
            [0.05, 3.46, 3.45],
            [0.05, 3.47, 3.45],
            [0.10, 3.40, 3.40],
            [0.10, 3.41, 3.40],
            [0.10, 3.44, 3.40],
            [0.10, 3.45, 3.40],
            [0.10, 3.46, 3.40],
            [0.10, 3.47, 3.40],
        ];
    }
}
