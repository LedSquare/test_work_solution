<?php

namespace App\modules\Journey\Domain\Discount\Rules;


interface DiscountRuleInterface
{
    public function recalculate(): int;
}
