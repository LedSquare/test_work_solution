<?php

namespace Journey\Domain\Discount\DateIntervals;

use DateTime;

final readonly class StartTravelDateInterval
{
    public function __construct(
        public DateTime $start,
        public DateTime $end,
        /**
         * @var array<PaymentDateInterval>
         */
        public array $paymentDateIntervals,
    ) {
    }
}
