<?php
declare(strict_types=1);

/**
 * @author Volodymyr Artjukh
 * @copyright 2024 Volodymyr Artjukh (vladimir.artjukh@gmail.com)
 */

namespace App\Services\Bin;

/**
 * Implementation of BinProviderInterface using the Binlist API.
 */
class BinlistProvider implements BinProviderInterface
{
    const int ATTEMPTS = 5;
    const int SLEEP = 60;
    const int TOO_MANY_REQUESTS_CODE = 429;
    const int DEFAULT_ATTEMPTS = 0;


    /**
     * Get the country code from the BIN number using Binlist API.
     * @param string $bin The BIN number
     * @return string The country code
     * @throws \Exception
     */
    public function getCountryCode(string $bin, int $attempt = self::DEFAULT_ATTEMPTS): string
    {
        $response = file_get_contents($_ENV['BIN_API_URL'] . $bin);
        if (!$response) {
            $httpCode = http_response_code();

            //https://lookup.binlist.net/ has limit Requests are throttled at 5 per hour with a burst allowance of 5
            if ($httpCode === self::TOO_MANY_REQUESTS_CODE && $attempt <= self::ATTEMPTS) {
                // If 429, wait before retrying
                sleep(self::SLEEP);
                $attempt++;
                $this->getCountryCode($bin, $attempt);

            } else {
                throw new \Exception('Failed to retrieve BIN information');

            }
        }
        $data = json_decode($response);
        return $data->country->alpha2 ?? '';
    }
}
