<?php

namespace App\modules\Journey\Domain\Discount\DateIntervals;

use DateTime;

final readonly class StartTravelDateInterval
{
    public function __construct(
        public DateTime $start,
        public DateTime $end,
        /**
         * @var array<\App\modules\Journey\Domain\Discount\DateIntervals\PaymentDateInterval>
         */
        public array $paymentDateIntervals,
    ) {
    }
}
