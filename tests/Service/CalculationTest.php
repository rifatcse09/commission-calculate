<?php

declare(strict_types=1);

namespace Application\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Application\CommissionTask\Index;

final class CalculationTest extends TestCase
{
    private $inputs,$output = [];

    public function setUp():void
    {
        $this->inputs = [
            '2022-07-04,4,private,withdraw,1500.00,EUR',
            '2016-07-05,2,business,withdraw,1000.00,EUR',
            '2016-07-06,2,business,deposit,10000.00,EUR',
            '2016-07-06,2,private,deposit,10000.00,EUR',
        ];

        $this->output = [1.5,5,3,3];
    }

    public function testCommissionCalculation():void
    {   
        $mainClass = new Index($this->inputs, Index::TEST_ENV);
        $result = $mainClass->calculate();
        $this->assertEqualsCanonicalizing($this->output, $result);
    }

}