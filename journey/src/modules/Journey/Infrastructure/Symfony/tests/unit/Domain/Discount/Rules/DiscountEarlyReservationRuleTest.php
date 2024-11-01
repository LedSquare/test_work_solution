<?php

namespace App\modules\Journey\Infrastructure\Symfony\tests\unit\Domain\Discount\Rules;

use App\modules\Journey\Domain\Discount\DateIntervals\PaymentDateInterval;
use App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval;
use App\modules\Journey\Domain\Discount\Rules\DiscountEarlyReservationRule;
use DateTime;
use PHPUnit\Framework\TestCase;

class DiscountEarlyReservationRuleTest extends TestCase
{
    /**
     * @test
     * @dataProvider datesProvider
     */
    public function test_recalculate_sucess(
        $baseCost,
        $startTravelDate,
        $paymentDate,
        $expectedDiscount,
    ): void {

        $startTravelDateInterval = new StartTravelDateInterval(
            start: new DateTime('01-01-2025'),
            end: new DateTime('05-08-2025'),
            paymentDateIntervals: [
                new PaymentDateInterval(
                    start: new DateTime('02-02-2025'),
                    end: new DateTime('02-04-2025'),
                    discountProcent: 5
                ),

                new PaymentDateInterval(
                    start: new DateTime('03-04-2025'),
                    end: new DateTime('02-05-2025'),
                    discountProcent: 3
                ),
            ]
        );

        $rule = new DiscountEarlyReservationRule(
            baseCost: $baseCost,
            startTravelDate: $startTravelDate,
            paymentDate: $paymentDate,
            startDateIntervals: [
                $startTravelDateInterval
            ],
        );

        $this->assertEquals($expectedDiscount, $rule->recalculate());
    }

    public static function datesProvider(): array
    {
        return [
            '5_procent' => [
                20000,
                new DateTime('01-04-2025'),
                new DateTime('02-03-2025'),
                1000
            ],

            '3_procent' => [
                23000,
                new DateTime('01-04-2025'),
                new DateTime('05-04-2025'),
                690
            ],

            'incorrect_start_travel_date' => [
                30000,
                new DateTime('01-01-2026'),
                new DateTime('01-01-2026'),
                0
            ],

            'incorrect_start_payment_date' => [
                20000,
                new DateTime('01-07-2025'),
                new DateTime('02-06-2025'),
                0
            ],

        ];
    }
}
