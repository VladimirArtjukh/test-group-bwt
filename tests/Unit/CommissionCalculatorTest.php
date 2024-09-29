<?php
declare(strict_types=1);

/**
 * @author Volodymyr Artjukh
 * @copyright 2024 Volodymyr Artjukh (vladimir.artjukh@gmail.com)
 */

namespace Unit;

use App\Services\Bin\BinProviderInterface;
use App\Services\CommissionCalculator;
use App\Services\Exchange\ExchangeRateProviderInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the CommissionCalculator class.
 */
class CommissionCalculatorTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testCalculateCommissionEuCard(): void
    {
        // Mock the BinProvider to return a European country code
        $binProvider = $this->createMock(BinProviderInterface::class);
        $binProvider->method('getCountryCode')->willReturn('DE');

        // Mock the ExchangeRateProvider to return 1 for EUR
        $exchangeRateProvider = $this->createMock(ExchangeRateProviderInterface::class);
        $exchangeRateProvider->method('getExchangeRate')->willReturn(1.0);

        // Create the CommissionCalculator with the mocked providers
        $calculator = new CommissionCalculator($binProvider, $exchangeRateProvider);

        // Calculate the commission
        $commission = $calculator->calculate('45717360', 100.00, 'EUR');

        // Assert the commission is correct
        $this->assertEquals(1.00, $commission);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testCalculateCommissionNonEuCard(): void
    {
        // Mock the BinProvider to return a non-European country code
        $binProvider = $this->createMock(BinProviderInterface::class);
        $binProvider->method('getCountryCode')->willReturn('US');

        // Mock the ExchangeRateProvider to return 1.1 for USD
        $exchangeRateProvider = $this->createMock(ExchangeRateProviderInterface::class);
        $exchangeRateProvider->method('getExchangeRate')->willReturn(1.1);

        // Create the CommissionCalculator with the mocked providers
        $calculator = new CommissionCalculator($binProvider, $exchangeRateProvider);

        // Calculate the commission
        $commission = $calculator->calculate('516793', 50.00, 'USD');

        // Assert the commission is correct
        $this->assertEquals(0.91, $commission); // Example commission, round to 0.91
    }
}
