<?php

namespace Unit;

use App\Services\TransactionValidator;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class TransactionValidatorTest extends TestCase
{
    /**
     * @var TransactionValidator
     */
    private TransactionValidator $validator;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->validator = new TransactionValidator();
    }

    /**
     * @return void
     */
    public function testValidateValidTransaction(): void
    {
        $data = [
            'bin' => '45717360',
            'amount' => '100.00',
            'currency' => 'EUR'
        ];

        $this->validator->validate($data); // No exception should be thrown
        $this->assertTrue(true); // Dummy assertion to indicate test passed
    }

    /**
     * @return void
     */
    public function testValidateMissingFields(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Missing required fields");

        $data = [
            'bin' => '45717360',
            // 'amount' => '100.00', // Missing amount
            'currency' => 'EUR'
        ];

        $this->validator->validate($data);
    }

    /**
     * @return void
     */
    public function testValidateInvalidBin(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid BIN number");

        $data = [
            'bin' => '123', // Invalid BIN (too short)
            'amount' => '100.00',
            'currency' => 'EUR'
        ];

        $this->validator->validate($data);
    }

    /**
     * @return void
     */
    public function testValidateInvalidAmount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid amount");

        $data = [
            'bin' => '45717360',
            'amount' => '-50.00', // Invalid amount (negative)
            'currency' => 'EUR'
        ];

        $this->validator->validate($data);
    }

    /**
     * @return void
     */
    public function testValidateInvalidCurrency(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid currency code");

        $data = [
            'bin' => '45717360',
            'amount' => '100.00',
            'currency' => 'EURO' // Invalid currency (not ISO 4217)
        ];

        $this->validator->validate($data);
    }
}
