<?php

namespace Journey\Domain\Discount\DateIntervals;

use DateTime;

final readonly class PaymentDateInterval
{
    public function __construct(
        public DateTime $start,
        public DateTime $end,
        public int $discountProcent,
    ) {
    }
}
