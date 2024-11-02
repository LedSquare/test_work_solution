<?php

namespace App\modules\Journey\Infrastructure\Symfony\tests\unit\Domain\Discount;

use App\modules\Journey\Domain\Discount\DiscountCost;
use App\modules\Journey\Domain\Discount\Rules\DiscountChieldRule;
use PHPUnit\Framework\TestCase;

class DiscountCostTest extends TestCase
{
    public function test_calculation_correct_success(): void
    {
        $baseCost = 20000;
        $mockReturned = ($baseCost * 80) / 100;

        $ruleMock = $this->getMockBuilder(DiscountChieldRule::class)
            ->setConstructorArgs([
                $baseCost,
                4
            ])
            ->onlyMethods(['recalculate'])
            ->getMock();
        $ruleMock->expects($this->once())
            ->method('recalculate')
            ->willReturn($mockReturned);

        $cost = new DiscountCost(
            $baseCost
        );

        $cost->recalculate($ruleMock);
        $this->assertEquals(
            $baseCost - $mockReturned,
            $cost->getFinalDiscountCost()
        );
    }
}
