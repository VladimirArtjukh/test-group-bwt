# Transaction Commission Calculator

## Description
This project calculates transaction commissions based on the BIN number (credit card issuer country) and exchange rates. It applies different commission rates for EU and non-EU issued cards.

## Features
- Dockerized PHP 8.3 environment
- Strategy Pattern for BIN provider and Exchange Rate provider
- Unit tests with PHPUnit
- Mocking of API responses for consistent test results
- Validation for inputs

## Prerequisites
- Docker
- Docker Compose

## Setup

1. Copy .env.example and call it .env. 
2. Generate api key https://manage.exchangeratesapi.io/dashboard and add it value to EXCHANGE_RATE_API_KEY
3. Build docker
   ```bash
   docker-compose up --build
   
4. Build commposer
   ```bash
   docker-compose exec app composer install
   
5. Running the Application
   ```bash
   docker-compose exec app php /var/www/app.php /var/www/input.txt
   
## Testing
1. Run tests
  ```bash
   docker-compose exec app vendor/bin/phpunit tests
