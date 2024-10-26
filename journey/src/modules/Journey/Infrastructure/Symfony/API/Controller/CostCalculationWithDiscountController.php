<?php

namespace App\modules\Journey\UI\Symfony\API\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CostCalculationWithDiscountController extends AbstractController
{
    #[Route('discount_calculation', methods: 'GET', name: 'journey_discount_calculation')]
    public function index(): JsonResponse
    {
        return $this->json('some');
    }
}
