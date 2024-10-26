<?php

namespace App\modules\Journey\Infrastructure\Symfony\API\Request;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class CostCalculationWithDiscountValidationRequest
{
    public function __construct(
        #[Assert\NotBlank()]
        #[Assert\Positive()]
        public readonly int $baseCost,

        #[Assert\NotBlank()]
        #[Assert\Type('\DateTime')]
        public readonly DateTime $birthDate,
        #[Assert\NotBlank()]
        #[Assert\Type('\DateTime')]
        public readonly DateTime $startTravelDate,
        #[Assert\NotBlank()]
        #[Assert\Type('\DateTime')]
        public readonly DateTime $paymentDate,
    ) {
    }
}
