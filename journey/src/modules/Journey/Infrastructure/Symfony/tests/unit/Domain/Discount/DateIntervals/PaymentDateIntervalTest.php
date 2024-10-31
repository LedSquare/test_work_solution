<?php

namespace App\modules\Journey\Infrastructure\Symfony\tests\unit\Domain\Discount\DateIntervals;

use App\modules\Journey\Domain\Discount\DateIntervals\PaymentDateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

class PaymentDateIntervalTest extends TestCase
{
    /**
     * @test
     */
    public function test_creation_sucess(): void
    {
        $start = new DateTime('01-10-2023');
        $end = new DateTime('01-11-2023');
        $discountProcent = 7;

        $dateInterval = new PaymentDateInterval(
            $start,
            $end,
            $discountProcent,
        );

        $this->assertEquals($start, $dateInterval->start);
        $this->assertEquals($end, $dateInterval->end);
        $this->assertEquals($discountProcent, $dateInterval->discountProcent);
    }
}
