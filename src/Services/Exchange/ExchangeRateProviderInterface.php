<?php
declare(strict_types=1);

/**
 * @author Volodymyr Artjukh
 * @copyright 2024 Volodymyr Artjukh (vladimir.artjukh@gmail.com)
 */

namespace App\Services\Exchange;

/**
 * Interface for exchange rate providers.
 */
interface ExchangeRateProviderInterface
{
    /**
     * Get the exchange rate for a specific currency.
     * @param string $currency The currency to get the rate for
     * @return float The exchange rate
     */
    public function getExchangeRate(string $currency): float;
}
