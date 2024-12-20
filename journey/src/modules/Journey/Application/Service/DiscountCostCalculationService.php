<?php

namespace App\modules\Journey\Application\Service;

use App\modules\Journey\Application\DTOResponse\CostCalculationResponseDTO;
use App\modules\Journey\Application\Service\DiscountCostCalculationServiceInterface;
use App\modules\Journey\Domain\DTORequest\CostCalculationRequestDTOInterface;
use App\modules\Journey\Domain\DTOResponse\CostCalculationResponseDTOInterface;
use App\modules\Journey\Domain\Discount\DateIntervals\PaymentDateInterval;
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
        $intervals = $this->setStartTravelAndPaymentDateIntervals();
        $discountCost = $this->discountCalculateService->calculate(
            requestDTO: $requestDTO,
            startTravelDateIntervals: $intervals
        );

        return new CostCalculationResponseDTO(
            discountCost: $discountCost
        );
    }

    /**
     * @var array<\App\modules\Journey\Domain\Discount\DateIntervals\StartTravelDateInterval>
     */
    private function setStartTravelAndPaymentDateIntervals(): array
    {
        $nowDate = new DateTime();
        $currentYear = $nowDate->format('Y');

        $newNowDate = new DateTime();
        $nextYear = $newNowDate->modify('+1 year')->format('Y');
        // Допустим получили эти интервали типо из базы
        // p.s. Високосный год не учитываю
        return [

            new StartTravelDateInterval(
                start: new DateTime("01-04-$nextYear"),
                end: new DateTime("30-09-$nextYear"),
                paymentDateIntervals: [
                    new PaymentDateInterval(
                        start: new DateTime("01-01-$currentYear"),
                        end: new DateTime("30-11-$currentYear"),
                        discountProcent: 7
                    ),
                    new PaymentDateInterval(
                        start: new DateTime("30-11-$currentYear"),
                        end: new DateTime("31-12-$currentYear"),
                        discountProcent: 5
                    ),
                    new PaymentDateInterval(
                        start: new DateTime("01-01-$nextYear"),
                        end: new DateTime("31-01-$nextYear"),
                        discountProcent: 3
                    ),
                ],
            ),

            new StartTravelDateInterval(
                start: new DateTime("01-10-$currentYear"),
                end: new DateTime("14-01-$nextYear"),
                paymentDateIntervals: [
                    new PaymentDateInterval(
                        start: new DateTime("01-01-$currentYear"),
                        end: new DateTime("29-03-$currentYear"),
                        discountProcent: 7
                    ),
                    new PaymentDateInterval(
                        start: new DateTime("29-03-$currentYear"),
                        end: new DateTime("30-04-$currentYear"),
                        discountProcent: 5
                    ),
                    new PaymentDateInterval(
                        start: new DateTime("30-04-$currentYear"),
                        end: new DateTime("31-05-$currentYear"),
                        discountProcent: 3
                    ),
                ]
            ),

            new StartTravelDateInterval(
                start: new DateTime("15-01-$nextYear"),
                end: new DateTime('01-01-2099'),
                paymentDateIntervals: [
                    new PaymentDateInterval(
                        start: new DateTime("01-01-$currentYear"),
                        end: new DateTime("29-08-$currentYear"),
                        discountProcent: 7
                    ),
                    new PaymentDateInterval(
                        start: new DateTime("29-08-$currentYear"),
                        end: new DateTime("30-09-$currentYear"),
                        discountProcent: 5
                    ),
                    new PaymentDateInterval(
                        start: new DateTime("30-09-$currentYear"),
                        end: new DateTime("31-10-$currentYear"),
                        discountProcent: 3
                    ),
                ]
            ),
        ];
    }
}
