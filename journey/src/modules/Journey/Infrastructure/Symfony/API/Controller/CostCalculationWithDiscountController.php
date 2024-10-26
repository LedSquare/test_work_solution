<?php

namespace App\modules\Journey\Infrastructure\Symfony\API\Controller;

use App\modules\Journey\Application\DTORequest\CostCalculationRequestDTO;
use App\modules\Journey\Application\Service\DiscountCostCalculationServiceInterface;
use App\modules\Journey\Infrastructure\Symfony\API\Request\CostCalculationWithDiscountValidationRequest;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CostCalculationWithDiscountController extends AbstractController
{
    public function __construct(
        private DiscountCostCalculationServiceInterface $discountCostCalculationService
    ) {
    }

    #[Route(path: 'discount_calculation', name: 'journey_discount_calculation', methods: 'POST')]
    public function index(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $request = new CostCalculationWithDiscountValidationRequest(
            baseCost: $data['base_cost'],
            birthDate: new DateTime($data['birth_date']),
            startTravelDate: new DateTime($data['start_travel_date']),
            paymentDate: new DateTime($data['payment_date']),
        );

        $validator->validate($request);

        $dto = new CostCalculationRequestDTO(
            baseCost: $request->baseCost,
            birthDate: $request->birthDate,
            startTravelDate: $request->startTravelDate,
            paymentDate: $request->paymentDate,
        );

        $responseDto = $this->discountCostCalculationService->calculate($dto);

        return $this->json(data: $responseDto);
    }
}
