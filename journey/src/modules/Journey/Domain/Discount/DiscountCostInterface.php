<?php

namespace App\modules\Journey\Domain\Discount;

use App\modules\Journey\Domain\Discount\Rules\DiscountRuleInterface;

interface DiscountCostInterface
{
    public function getFinalDiscountCost(): int;

    public function recalculate(DiscountRuleInterface $discountRule): self;
}
