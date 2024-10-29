<?php

namespace App\modules\Journey\Domain\Tests\Unit\Discount\DateIntervals;

use App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval;
use PHPUnit\Framework\TestCase;

class StartTravelDateIntervalTest extends TestCase
{
    /**
     * @test
     */
    public function test_create_date_interval_success(): void
    {
        $dateInterval = new StartTravelDateInterval(
            new DateTime('01-10-2023'),
            new DateTime('01-11-2023'),

        );


    }
}
