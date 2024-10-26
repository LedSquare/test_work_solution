<?php

namespace Journey\Application\DTORequest;

use DateTime;

use Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;

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
