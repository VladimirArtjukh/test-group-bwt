<?php
declare(strict_types=1);

/**
 * @author Volodymyr Artjukh
 * @copyright 2024 Volodymyr Artjukh (vladimir.artjukh@gmail.com)
 */

namespace App\Helpers;

/**
 * Helper class to handle country-related functionality.
 */
class CountryHelper
{
    /**
     * @var array|string[]
     */
    private static array $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];

    /**
     * Check if the given country is an EU country.
     * @param string $countryCode The country code
     * @return bool True if the country is in the EU
     */
    public static function isEuCountry(string $countryCode): bool
    {
        return in_array($countryCode, self::$euCountries);
    }
}
