<?php

namespace App\modules\Journey\Application\DTOResponse;

use App\modules\Journey\Domain\DTOResponse\CostCalculationResponseDTOInterface;

readonly class CostCalculationResponseDTO implements CostCalculationResponseDTOInterface
{
    public function __construct(
        public int $discountCost
    ) {
    }
}
