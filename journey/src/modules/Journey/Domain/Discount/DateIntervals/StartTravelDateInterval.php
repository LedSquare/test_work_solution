<?php

namespace App\modules\Journey\Domain\Discount\DateIntervals;

use App\modules\Journey\Domain\Discount\DateIntervals\PaymentDateInterval;
use App\modules\Journey\Domain\Exceptions\Discount\DiscountDateException;
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
        $this->validate();
    }

    public function validate(): void
    {
        if ($this->start >= $this->end) {
            throw new DiscountDateException('The start date of the interval is greater than the end date', 422);
        }

        if (!$this->paymentDateIntervals[0] instanceof PaymentDateInterval) {
            throw new \InvalidArgumentException('Wrong payment date type', 400);
        }
    }
}
