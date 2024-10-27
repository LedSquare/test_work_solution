<?php

namespace App\modules\Journey\Infrastructure\Symfony\tests\feature;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use function restore_exception_handler;

class CostCalculationWithDiscountSecondDateIntervalFeatureTest extends WebTestCase
{
    private $client;

    private $currentYear;
    private $nextYear;

    public function setUp(): void
    {
        $this->client = static::createClient();

        $currentYear = new DateTime();
        $nextYear = new DateTime();
        $this->currentYear = $currentYear->format('Y');
        $this->nextYear = $nextYear->modify('+1 year')->format('Y');
    }

    public function test_discount_before_mart_seven_procent_success(): void
    {
        $baseCost = 12000;
        $req_data = json_encode([
            'base_cost' => $baseCost,
            'birth_date' => '27-11-1996',
            'start_travel_date' => "01-11-{$this->currentYear}",
            'payment_date' => "15-03-{$this->currentYear}",
        ]);

        $expectedFinalCost = $baseCost - ($baseCost * 7) / 100;

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

        $finalCost = $this->client
            ->getResponse()
            ->getContent();
        $finalCost = json_decode($finalCost);

        $this->assertEquals($expectedFinalCost, $finalCost->discountCost);

        restore_exception_handler();
    }


    public function test_discount_after_mart_five_procent_success(): void
    {
        $baseCost = 12000;

        $req_data = json_encode([
            'base_cost' => $baseCost,
            'birth_date' => '22-11-1996',
            'start_travel_date' => "13-01-{$this->nextYear}",
            'payment_date' => "10-04-{$this->currentYear}",
        ]);

        $expectedFinalCost = $baseCost - ($baseCost * 5) / 100;

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

        $finalCost = $this->client
            ->getResponse()
            ->getContent();
        $finalCost = json_decode($finalCost);

        $this->assertEquals($expectedFinalCost, $finalCost->discountCost);

        restore_exception_handler();
    }

    public function test_discount_after_april_three_procent_success(): void
    {
        $baseCost = 12000;

        $req_data = json_encode([
            'base_cost' => $baseCost,
            'birth_date' => '22-11-1996',
            'start_travel_date' => "13-01-{$this->nextYear}",
            'payment_date' => "02-05-{$this->currentYear}",
        ]);

        $expectedFinalCost = $baseCost - ($baseCost * 3) / 100;

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

        $finalCost = $this->client
            ->getResponse()
            ->getContent();
        $finalCost = json_decode($finalCost);

        $this->assertEquals($expectedFinalCost, $finalCost->discountCost);

        restore_exception_handler();
    }
}
