<?php

namespace App\modules\Journey\Domain\Discount\Rules;

use App\modules\Journey\Domain\Enums\Discount\Rules\DiscountChieldEnum;

final class DiscountChieldRule implements DiscountRuleInterface
{
    const MAX_DISCOUNT_COST_IF_SIX_YEAR = 4500;

    public function __construct(
        private int $discountCost,
        private int $age,
    ) {
    }
    public function recalculate(): int
    {
        $procent = DiscountChieldEnum::getProcent($this->age);

        $finalCost = ($this->discountCost * $procent) / 100;

        if ($this->age >= 6 && $this->age < 12) {
            if ($finalCost >= self::MAX_DISCOUNT_COST_IF_SIX_YEAR) {
                $finalCost = self::MAX_DISCOUNT_COST_IF_SIX_YEAR;
            }
        }

        return (int) $finalCost;
    }
}
