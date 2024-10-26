<?php

namespace Journey\Domain\Discount\Rules;


interface DiscountRuleInterface
{
    public function recalculate(): int;
}
