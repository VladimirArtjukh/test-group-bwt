<?php
declare(strict_types=1);

/**
 * @author Volodymyr Artjukh
 * @copyright 2024 Volodymyr Artjukh (vladimir.artjukh@gmail.com)
 */

namespace App\Services;

use App\Helpers\CountryHelper;
use App\Services\Bin\BinProviderInterface;
use App\Services\Exchange\ExchangeRateProviderInterface;

/**
 * Class to calculate commission based on transaction details.
 */
class CommissionCalculator
{
    private BinProviderInterface $binProvider;
    private ExchangeRateProviderInterface $exchangeRateProvider;

    /**
     * CommissionCalculator constructor.
     * @param BinProviderInterface $binProvider
     * @param ExchangeRateProviderInterface $exchangeRateProvider
     */
    public function __construct(BinProviderInterface $binProvider, ExchangeRateProviderInterface $exchangeRateProvider)
    {
        $this->binProvider = $binProvider;
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    /**
     * Calculate the commission for a transaction.
     * @param string $bin The BIN number of the credit card
     * @param float $amount The transaction amount
     * @param string $currency The transaction currency
     * @return float The calculated commission
     * @throws \Exception
     */
    public function calculate(string $bin, float $amount, string $currency): float
    {
        // Get the country code using the BIN provider
        $countryCode = $this->binProvider->getCountryCode($bin);

        // Check if the country is in the EU
        $isEu = CountryHelper::isEuCountry($countryCode);

        // Get the exchange rate for the currency
        $rate = ($currency == 'EUR') ? 1 : $this->exchangeRateProvider->getExchangeRate($currency);

        if ($rate == 0) {
            throw new \Exception("Invalid exchange rate for currency: $currency");
        }

        // Convert amount to EUR
        $amountInEur = $amount / $rate;

        // Calculate commission
        $commissionRate = $isEu ? 0.01 : 0.02;
        $commission = $amountInEur * $commissionRate;

        // Ceiling to nearest cent
        return ceil($commission * 100) / 100;
    }
}
