<?php
declare(strict_types=1);

/**
 * @author Volodymyr Artjukh
 * @copyright 2024 Volodymyr Artjukh (vladimir.artjukh@gmail.com)
 */

namespace App\Services\Bin;

/**
 * Interface for BIN number providers.
 */
interface BinProviderInterface
{
    /**
     * Get the country code from the BIN number.
     * @param string $bin The BIN number of the credit card
     * @return string The country code of the BIN number
     */
    public function getCountryCode(string $bin): string;
}
