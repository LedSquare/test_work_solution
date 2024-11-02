<?php

namespace App\modules\Journey\Presentation\Symfony\API\Controller;

use App\modules\Journey\Application\DTORequest\CostCalculationRequestDTO;
use App\modules\Journey\Application\Service\DiscountCostCalculationServiceInterface;
use App\modules\Journey\Presentation\Symfony\API\Request\CostCalculationWithDiscountRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CostCalculationWithDiscountController extends AbstractController
{
    public function __construct(
        private DiscountCostCalculationServiceInterface $discountCostCalculationService
    ) {
    }

    #[Route(path: 'discount_calculation', name: 'journey_discount_calculation', methods: 'POST')]
    public function index(
        #[MapRequestPayload] CostCalculationWithDiscountRequest $request
    ): JsonResponse {

        $dto = new CostCalculationRequestDTO(
            baseCost: $request->base_cost,
            birthDate: $request->birth_date,
            startTravelDate: $request->start_travel_date,
            paymentDate: $request->payment_date,
        );

        $responseDto = $this->discountCostCalculationService->calculate($dto);
        return $this->json(data: $responseDto);
    }
}
