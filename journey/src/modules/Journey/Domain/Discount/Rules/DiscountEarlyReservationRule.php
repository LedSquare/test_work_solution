<?php

namespace App\modules\Journey\Domain\Discount\Rules;

use App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval;

use DateTime;

final class DiscountEarlyReservationRule implements DiscountRuleInterface
{

    public function __construct(
        private int $baseCost,
        private DateTime $startTravelDate,
        private DateTime $paymentDate,
        /**
         * @var array<StartTravelDateInterval>
         */
        private array $startDateIntervals,
    ) {
    }
    public function recalculate(): int
    {
        $discount = 0;
        foreach ($this->startDateIntervals as $startDateInterval) {
            if (
                $this->startTravelDate >= $startDateInterval->start &&
                $this->startTravelDate <= $startDateInterval->end
            ) {
                foreach ($startDateInterval->paymentDateIntervals as $paymentInterval) {
                    if (
                        $this->paymentDate >= $paymentInterval->start &&
                        $this->paymentDate < $paymentInterval->end
                    ) {
                        $procent = $paymentInterval->discountProcent;
                        $discount = ($this->baseCost * $procent) / 100;
                        return $discount;
                    }
                }
            }
        }
        return $discount;
    }
}
