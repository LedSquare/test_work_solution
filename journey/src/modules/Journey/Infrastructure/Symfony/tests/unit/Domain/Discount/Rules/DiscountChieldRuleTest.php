<?php

namespace App\modules\Journey\Infrastructure\Symfony\tests\unit\Domain\Discount\Rules;

use App\modules\Journey\Domain\Discount\Rules\DiscountChieldRule;
use App\modules\Journey\Domain\Enums\Discount\Rules\DiscountChieldEnum;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DiscountChieldRuleTest extends KernelTestCase
{
    /**
     * @test
     * @dataProvider costAndAgeProvider
     */
    public function test_recalculate_sucess(
        $cost,
        $age,
        $expectedDiscount,
        $expectedProcentFromEnum
    ): void {
        $this->assertEquals($expectedProcentFromEnum, DiscountChieldEnum::getProcent($age));

        $rule = new DiscountChieldRule(
            $cost,
            $age,
        );

        $result = $rule->recalculate();

        $this->assertEquals($expectedDiscount, $result);
    }

    public static function costAndAgeProvider(): array
    {
        return [
            '3_year_discount' => [
                12000,
                4,
                9600,
                80,
            ],

            '6_year_discount_smaller_than_4500' => [
                12000,
                9,
                3600,
                30,
            ],

            '6_year_final_discount_bigger_than_4500' => [
                20000,
                8,
                4500,
                30,
            ],

            '12_year_discount' => [
                25000,
                15,
                3000,
                12,
            ]
        ];
    }
}
