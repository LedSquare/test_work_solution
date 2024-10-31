<?php

declare(strict_types=1);

namespace App\modules\Journey\Infrastructure\Symfony\tests\feature;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Request;
use function restore_exception_handler;

class CostCalculationWithDiscountFirstDateIntervalTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->setServerParameter('CONTENT_TYPE', 'application/json');
    }

    /**
     * 
     * @return array<string, array{
     * baseCost: int,
     * birthDate: string,
     * startTravelDate: string,
     * paymentDate: string,
     * discountProcent: int,
     * }>
     */
    public static function providerDateIntervalsData(): array
    {
        $currentYear = (new DateTime())->format('Y');
        $nextYear = (new DateTime())
            ->modify('+1 year')
            ->format('Y');

        $baseCost = 12000;
        return [
            'before_mart_and_seven_procent' => [
                $baseCost,
                '27-11-1996',
                "01-11-$currentYear",
                "15-03-$currentYear",
                7
            ],
            'in_april_and_five_procent' => [
                $baseCost,
                '27-11-1996',
                "13-01-$nextYear",
                "10-04-$currentYear",
                5
            ],
            'in_may_and_three_procent' => [
                $baseCost,
                '27-11-1996',
                "13-01-$nextYear",
                "02-05-$currentYear",
                3
            ],
        ];
    }

    /**
     * @test
     * @dataProvider providerDateIntervalsData
     */
    public function test_discount_calculation_success(
        int $baseCost,
        string $birthDate,
        string $startTravelDate,
        string $paymentDate,
        int $discountProcent
    ): void {
        $req_data = json_encode([
            'base_cost' => $baseCost,
            'birth_date' => $birthDate,
            'start_travel_date' => $startTravelDate,
            'payment_date' => $paymentDate,
        ]);

        $expectedFinalCost = $baseCost - ($baseCost * $discountProcent) / 100;

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
