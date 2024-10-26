<?php

namespace Journey\Domain\Discount;

use Journey\Domain\Discount\Rules\DiscountRuleInterface;

interface DiscountCostInterface
{
    public function getFinalCost(): int;

    public function recalculate(DiscountRuleInterface $discountRule): self;
}
