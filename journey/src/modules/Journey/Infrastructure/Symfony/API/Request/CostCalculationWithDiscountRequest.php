<?php

namespace App\modules\Journey\Infrastructure\Symfony\API\Request;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CostCalculationWithDiscountRequest
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Positive()]
        public readonly int $base_cost,
        // public readonly int $base_cost,

        #[Assert\NotBlank()]
        #[Assert\Type('\DateTime')]
        #[Assert\Type('\DateTime')]
        public readonly DateTime $birth_date,
        // public readonly DateTime $birth_date,

        #[Assert\NotBlank()]
        #[Assert\Type('\DateTime')]
        public readonly DateTime $start_travel_date,
        // public readonly DateTime $start_travel_date,

        #[Assert\NotBlank()]
        #[Assert\Type('\DateTime')]
        public readonly DateTime $payment_date,
        // public readonly DateTime $payment_date,
    ) {
    }
}
