<?php
declare(strict_types=1);

/**
 * @author Volodymyr Artjukh
 * @copyright 2024 Volodymyr Artjukh (vladimir.artjukh@gmail.com)
 */

namespace App\Services\Exchange;

/**
 * Implementation of ExchangeRateProviderInterface using ExchangeRatesAPI.
 */
class ExchangeRatesApiProvider implements ExchangeRateProviderInterface
{
    const ZERO_RATE = 0;

    /**
     * Get the exchange rate for a specific currency.
     * @param string $currency The currency
     * @return float The exchange rate
     * @throws \Exception
     */
    public function getExchangeRate(string $currency): float
    {
        $url = "{$_ENV['EXCHANGE_RATE_API_URL']}?access_key={$_ENV['EXCHANGE_RATE_API_KEY']}";
        $response = file_get_contents($url);
        if (!$response) {
            throw new \Exception('Failed to retrieve exchange rate information');
        }
        $data = json_decode($response, true);
        return $data['rates'][$currency] ?? self::ZERO_RATE;
    }
}
