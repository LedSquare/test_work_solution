<?php

namespace Journey\Domain\Service\Discount;

use Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;

interface DiscountCalculateServiceInterface
{
    /**
     * 
     * @param \Journey\Domain\DTORequest\CostCalculationRequestDTOInterface $requestDTO
     * @param array<\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval> $startTravelDateIntervals
     * @return int
     */
    public function calculate(CostCalculationRequestDTOInterface $requestDTO, array $startTravelDateIntervals = null): int;
}
