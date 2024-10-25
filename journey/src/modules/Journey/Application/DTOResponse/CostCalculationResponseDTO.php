<?php

namespace App\modules\Journey\Application\DTORequest;

use App\modules\Journey\Domain\DTOResponse\CostCalculationResponseDTOInterface;

readonly class CostCalculationResponseDTO implements CostCalculationResponseDTOInterface
{
    public function __construct(
        public int $discount
    ) {
    }
}
