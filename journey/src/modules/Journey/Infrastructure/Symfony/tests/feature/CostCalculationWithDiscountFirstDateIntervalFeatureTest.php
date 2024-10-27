<?php

namespace App\modules\Journey\Infrastructure\Symfony\tests\feature;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use function restore_exception_handler;

class CostCalculationWithDiscountFirstDateIntervalFeatureTest extends WebTestCase
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

    public function test_discount_before_november_seven_procent_success(): void
    {
        $baseCost = 10000;
        $req_data = json_encode([
            'base_cost' => $baseCost,
            'birth_date' => '27-11-1996',
            'start_travel_date' => "01-04-{$this->nextYear}",
            'payment_date' => "10-10-{$this->currentYear}",
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


    public function test_discount_after_november_with_chield_discount_three_year_and_five_procent_success(): void
    {
        $baseCost = 10000;
        $threeAgeOld = new DateTime();
        $threeAgeOld = $threeAgeOld->modify('-4 year')->format('Y');
        $threeYearDate = "01-01-$threeAgeOld";


        $req_data = json_encode([
            'base_cost' => $baseCost,
            'birth_date' => $threeYearDate,
            'start_travel_date' => "02-04-{$this->nextYear}",
            'payment_date' => "10-12-{$this->currentYear}",
        ]);

        $expectedFinalCost = $baseCost - ($baseCost * 80) / 100; //3 year chield case
        $expectedFinalCost -= ($expectedFinalCost * 5) / 100;

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

    public function test_discount_after_december_with_chield_discount_three_year_and_three_procent_success(): void
    {
        $baseCost = 10000;
        $threeAgeOld = new DateTime();
        $threeAgeOld = $threeAgeOld->modify('-4 year')->format('Y');
        $threeYearDate = "01-01-$threeAgeOld";


        $req_data = json_encode([
            'base_cost' => $baseCost,
            'birth_date' => $threeYearDate,
            'start_travel_date' => "02-04-{$this->nextYear}",
            'payment_date' => "05-01-{$this->nextYear}",
        ]);

        $expectedFinalCost = $baseCost - ($baseCost * 80) / 100; //3 year chield case
        $expectedFinalCost -= ($expectedFinalCost * 3) / 100;

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
