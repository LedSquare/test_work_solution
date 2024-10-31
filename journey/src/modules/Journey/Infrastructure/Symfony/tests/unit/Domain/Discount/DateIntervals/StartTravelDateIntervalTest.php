<?php

namespace App\modules\Journey\Infrastructure\Symfony\tests\unit\Domain\Discount\DateIntervals;

use App\modules\Journey\Domain\Discount\DateIntervals\PaymentDateInterval;
use App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

class StartTravelDateIntervalTest extends TestCase
{
    /**
     * @test
     */
    public function test_creation_success(): void
    {
        $start = new DateTime('01-10-2023');
        $end = new DateTime('01-11-2023');
        $paymentDateIntervals = [
            $this->createMock(PaymentDateInterval::class),
            $this->createMock(PaymentDateInterval::class),
        ];
        $dateInterval = new StartTravelDateInterval(
            $start,
            $end,
            $paymentDateIntervals,
        );

        $this->assertEquals($start, $dateInterval->start);
        $this->assertEquals($end, $dateInterval->end);
        $this->assertEquals($paymentDateIntervals, $dateInterval->paymentDateIntervals);
    }

    /**
     * @test
     */
    public function test_creation_invalid_argument_fail(): void
    {
        $start = new DateTime('01-10-2023');
        $end = new DateTime('01-11-2023');
        $paymentDateIntervals = [
            '10-10-2022',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $dateInterval = new StartTravelDateInterval(
            $start,
            $end,
            $paymentDateIntervals,
        );
    }

}
