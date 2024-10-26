<?php

namespace App\modules\Journey\Application\Service;

use App\modules\Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;
use App\modules\Journey\Domain\DTOResponse\CostCalculationResponseDTOInterface;

interface DiscountCostCalculationServiceInterface
{
    public function calculate(CostCalculationRequestDTOInterface $requestDTO): CostCalculationResponseDTOInterface;
}
