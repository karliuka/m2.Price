<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Test\Unit\Model\Calculator\RoundProcessor\Base;

use Faonni\Price\Test\Unit\Model\Calculator\RoundProcessor\AbstractTestCase;
use Faonni\Price\Model\Calculator\RoundProcessor\Base\FloorProcessor as Processor;

/**
 * Test base floor processor
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
     * @param float $precision
     * @param float $price
     * @param string $result
     * @return void
     * @dataProvider dataProviderRound
     * @test
     */
    public function testRound($precision, $price, $result)
    {
        $this->helper->expects($this->once())
            ->method('getPrecision')
            ->willReturn($precision);

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
            [-1, 1244, 1240],
            [-1, 1245, 1240],
            [-1, 1246, 1250],
            [-1, 1254, 1250],
            [-1, 1255, 1250],
            [-1, 1256, 1260],
            [-1, 1264, 1260],
            [-1, 1265, 1260],
            [-1, 1266, 1270],
            [-2, 1244, 1200],
            [-2, 1245, 1200],
            [-2, 1246, 1200],
            [-2, 1254, 1300],
            [-2, 1255, 1300],
            [-2, 1256, 1300],
            [-2, 1264, 1300],
            [-2, 1265, 1300],
            [-2, 1266, 1300],
            [0, 3.44, 3],
            [0, 3.45, 3],
            [0, 3.46, 3],
            [0, 3.54, 4],
            [0, 3.55, 4],
            [0, 3.56, 4],
            [0, 3.64, 4],
            [0, 3.65, 4],
            [0, 3.66, 4],
            [1, 3.44, 3.4],
            [1, 3.45, 3.4],
            [1, 3.46, 3.5],
            [1, 3.54, 3.5],
            [1, 3.55, 3.5],
            [1, 3.56, 3.6],
            [1, 3.64, 3.6],
            [1, 3.65, 3.6],
            [1, 3.66, 3.7],
            [2, 3.444, 3.44],
            [2, 3.445, 3.44],
            [2, 3.446, 3.45],
            [2, 3.454, 3.45],
            [2, 3.455, 3.45],
            [2, 3.456, 3.46],
            [2, 3.464, 3.46],
            [2, 3.465, 3.46],
            [2, 3.466, 3.47]
        ];
    }
}
