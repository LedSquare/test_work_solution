<?php

namespace App\modules\Journey\Application\Service;

use App\modules\Journey\Application\DTORequest\CostCalculationResponseDTO;
use App\modules\Journey\Application\Service\DiscountCostCalculationServiceInterface;
use App\modules\Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;
use App\modules\Journey\Domain\DTOResponse\CostCalculationResponseDTOInterface;
use App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval;
use App\modules\Journey\Domain\Service\Discount\DiscountCalculateServiceInterface;
use DateTime;

final class DiscountCostCalculationService implements DiscountCostCalculationServiceInterface
{
    public function __construct(
        private DiscountCalculateServiceInterface $discountCalculateService
    ) {
    }

    public function calculate(CostCalculationRequestDTOInterface $requestDTO): CostCalculationResponseDTOInterface
    {
        $discount = $this->discountCalculateService->calculate(requestDTO: $requestDTO);

        return new CostCalculationResponseDTO(
            discount: $discount
        );
    }

    /**
     * @var array<\App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval>
     */
    public function setStartTravelAndPaymentDates(): array
    {
        $nowDate = new DateTime();
        $currentYear = $nowDate->format('Y');

        $newNowDate = new DateTime();
        $nextYear = $newNowDate->modify('+1 year')->format('Y');
        // Допусти получили эти интервали типо из базы
        return [
            new StartTravelDateInterval(
                start: new DateTime("01-03-$currentYear"),
                end: new DateTime("01-02-$nextYear"),
                paymentDateIntervals: [

                ],
            )
        ];
    }
}
