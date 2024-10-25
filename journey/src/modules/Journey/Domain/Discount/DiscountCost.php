<?php

namespace App\modules\Journey\Domain\Discount;

use App\modules\Journey\Domain\Discount\Rules\DiscountRuleInterface;

final class DiscountCost implements DiscountCostInterface
{
    private int $finalCost;

    public function __construct(
        private readonly int $cost,
    ) {
        $this->finalCost = $cost;
    }

    /**
     * Get the value of finalCost
     */
    public function getFinalCost(): int
    {
        return $this->finalCost;
    }

    public function recalculate(DiscountRuleInterface $discountRule): self
    {
        $this->finalCost = $discountRule->recalculate();
        return $this;
    }
}
