<?php

namespace App\modules\Journey\Domain\Enums\Discount\Rules;

enum DiscountChieldEnum: int
{
    case threeYears = 80;
    case sixYears = 30;
    case twelveYears = 12;

    public static function getProcent(int $age): int
    {
        return match (true) {
            $age >= 3 && $age < 6 => self::threeYears->value,
            $age >= 6 && $age < 12 => self::sixYears->value,
            $age >= 12 && $age < 18 => self::twelveYears->value,
            default => 0,
        };
    }
}
