<?php

namespace App\modules\Journey\Domain\Discount;

use App\modules\Journey\Domain\Discount\Rules\DiscountRuleInterface;

interface DiscountCostInterface
{
    public function getFinalCost(): int;

    public function recalculate(DiscountRuleInterface $discountRule): self;
}
