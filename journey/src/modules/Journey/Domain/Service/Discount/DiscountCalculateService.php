<?php

namespace App\modules\Journey\Domain\Service\Discount;

use App\modules\Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;
use App\modules\Journey\Domain\Discount\DiscountCost;
use App\modules\Journey\Domain\Discount\Rules\DiscountChieldRule;
use App\modules\Journey\Domain\Discount\Rules\DiscountEarlyReservationRule;
use App\modules\Journey\Domain\Service\Discount\DiscountCalculateServiceInterface;

use DateTime;

final readonly class DiscountCalculateService implements DiscountCalculateServiceInterface
{
    public function calculate(CostCalculationRequestDTOInterface $requestDTO, array $startTravelDateIntervals = null): int
    {
        $discount = new DiscountCost(
            cost: $requestDTO->baseCost
        );

        $age = $this->calculateAge(birthDate: $requestDTO->birthDate);
        if ($age < 18) {
            $discountChieldRule = new DiscountChieldRule(
                discountCost: $discount->getFinalCost(),
                age: $age
            );
            $discount->recalculate(discountRule: $discountChieldRule);
        }

        $discountEarlyReservationRule = new DiscountEarlyReservationRule(
            discountCost: $discount->getFinalCost(),
            startTravelDate: $requestDTO->startTravelDate,
            paymentDate: $requestDTO->paymentDate,
            startDateIntervals: $startTravelDateIntervals,
        );

        $discount->recalculate(discountRule: $discountEarlyReservationRule);

        return $discount->getFinalCost();
    }

    private function calculateAge(DateTime $birthDate): int
    {
        $today = new DateTime();
        $age = $today->diff($birthDate);

        return $age->y;
    }

}
