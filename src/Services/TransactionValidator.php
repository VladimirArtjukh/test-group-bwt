<?php

namespace App\Services;

use InvalidArgumentException;

class TransactionValidator
{
    /**
     * Validates the transaction data.
     *
     * @param array $data The transaction data.
     * @throws InvalidArgumentException if validation fails.
     */
    public function validate(array $data): void
    {
        $this->validateRequiredFields($data);
        $this->validateBin($data['bin']);
        $this->validateAmount($data['amount']);
        $this->validateCurrency($data['currency']);
    }

    /**
     * Validates the presence of required fields.
     *
     * @param array $data The transaction data.
     * @throws InvalidArgumentException if required fields are missing.
     */
    private function validateRequiredFields(array $data): void
    {
        if (!isset($data['bin'], $data['amount'], $data['currency'])) {
            throw new InvalidArgumentException("Missing required fields: bin, amount, or currency.");
        }
    }

    /**
     * Validates the BIN number.
     *
     * @param string $bin The BIN number.
     * @throws InvalidArgumentException if the BIN is invalid.
     */
    private function validateBin(string $bin): void
    {
        if (!is_numeric($bin) || strlen($bin) < 6 || strlen($bin) > 8) {
            throw new InvalidArgumentException("Invalid BIN number: $bin");
        }
    }

    /**
     * Validates the amount.
     *
     * @param string $amount The transaction amount.
     * @throws InvalidArgumentException if the amount is not valid.
     */
    private function validateAmount(string $amount): void
    {
        if (!is_numeric($amount) || $amount <= 0) {
            throw new InvalidArgumentException("Invalid amount: $amount");
        }
    }

    /**
     * Validates the currency code.
     *
     * @param string $currency The currency code.
     * @throws InvalidArgumentException if the currency code is not valid.
     */
    private function validateCurrency(string $currency): void
    {
        if (!preg_match('/^[A-Z]{3}$/', $currency)) {
            throw new InvalidArgumentException("Invalid currency code: $currency");
        }
    }
}
