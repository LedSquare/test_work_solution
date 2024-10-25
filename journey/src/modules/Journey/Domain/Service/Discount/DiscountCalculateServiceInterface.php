<?php

namespace App\modules\Journey\Domain\Service\Discount;

use App\modules\Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;

interface DiscountCalculateServiceInterface
{
    /**
     * 
     * @param \App\modules\Journey\Domain\DTORequest\CostCalculationRequestDTOInterface $requestDTO
     * @param array<\App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval> $startTravelDateIntervals
     * @return int
     */
    public function calculate(CostCalculationRequestDTOInterface $requestDTO, array $startTravelDateIntervals = null): int;
}
