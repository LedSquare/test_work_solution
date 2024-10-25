<?php

namespace App\modules\Journey\Application\DTORequest;

use App\modules\Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;
use DateTime;

readonly class CostCalculationRequestDTO implements CostCalculationRequestDTOInterface
{
    public function __construct(
        public readonly int $baseCost,
        public readonly DateTime $birthDate,
        public readonly DateTime $startTravelDate,
        public readonly DateTime $paymentDate,
    ) {
    }
}
