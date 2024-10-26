<?php

namespace App\modules\Journey\Domain\Discount;

use App\modules\Journey\Domain\Discount\Rules\DiscountRuleInterface;

final class DiscountCost implements DiscountCostInterface
{
    private int $finalDiscountCost;

    public function __construct(
        public readonly int $cost,
    ) {
        $this->finalDiscountCost = $cost;
    }

    /**
     * Get the value of finalCost
     */
    public function getFinalDiscountCost(): int
    {
        return $this->finalDiscountCost;
    }

    public function recalculate(DiscountRuleInterface $discountRule): self
    {
        $this->finalDiscountCost -= $discountRule->recalculate();
        return $this;
    }
}
