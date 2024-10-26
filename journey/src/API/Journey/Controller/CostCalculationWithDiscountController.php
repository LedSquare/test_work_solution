<?php

namespace App\API\Journey\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class CostCalculationWithDiscountController extends AbstractController
{
    #[Route('/cost_calculate', name: 'some_name')]
    public function index(): JsonResponse
    {
        return $this->json('some value');
    }
}
