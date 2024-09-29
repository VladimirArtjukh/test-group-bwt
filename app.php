<?php

require __DIR__ . '/vendor/autoload.php';

use App\Services\Bin\BinlistProvider;
use App\Services\Exchange\ExchangeRatesApiProvider;
use App\Services\CommissionCalculator;
use App\Services\TransactionValidator;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ );
$dotenv->load();

if ($argc < 2) {
    throw new InvalidArgumentException("Usage: php app.php input.txt");
}

// Read input file
$inputFile = $argv[1];
if (!file_exists($inputFile)) {
    throw new InvalidArgumentException("Input file does not exist: $inputFile");
}

// Read file contents and process transactions
$transactions = file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($transactions === false) {
    throw new RuntimeException("Error reading input file: $inputFile");
}

$binlistProvider = new BinlistProvider();
$exchangeRatesProvider = new ExchangeRatesApiProvider();
$commissionCalculator = new CommissionCalculator($binlistProvider, $exchangeRatesProvider);

// Instantiate the TransactionValidator
$validator = new TransactionValidator();

foreach ($transactions as $row) {
    $data = json_decode($row, true);

    // Validate JSON input
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new InvalidArgumentException("Invalid JSON format: $row");
    }

    // Validate the transaction data
    $validator->validate($data);

    // Calculate the commission
    $commission = $commissionCalculator->calculate($data['bin'], $data['amount'], $data['currency']);
    echo $commission . PHP_EOL;
}
