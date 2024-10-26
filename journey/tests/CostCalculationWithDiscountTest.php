<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

use function restore_exception_handler;

class CostCalculationWithDiscountTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function test_discount_without_chield_success(): void
    {
        $req_data = json_encode([
            'base_cost' => 10000,
            'birth_date' => '27-11-1996',
            'start_travel_date' => '01-01-2025',
            'payment_date' => '10-10-2024',
        ]);

        $this->client
            ->request(
                method: Request::METHOD_POST,
                uri: '/journey/discount_calculation',
                content: $req_data
            );
        $code = $this->client
            ->getResponse()
            ->getStatusCode();

        $this->assertEquals(200, $code);

        restore_exception_handler();
    }
}
