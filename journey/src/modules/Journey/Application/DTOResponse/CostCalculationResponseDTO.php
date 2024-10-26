<?php

namespace Journey\Application\DTORequest;

use Journey\Domain\DTOResponse\CostCalculationResponseDTOInterface;

readonly class CostCalculationResponseDTO implements CostCalculationResponseDTOInterface
{
    public function __construct(
        public int $discount
    ) {
    }
}
