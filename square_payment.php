<?php

require 'vendor/autoload.php';

use Square\SquareClient;
use Square\Environment;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;

// Replace with your actual Square access token
$accessToken = 'YOUR_SQUARE_ACCESS_TOKEN';
$amount = 100; // Example amount, replace with actual amount
$currency = 'USD'; // Example currency, replace with actual currency

$client = new SquareClient([
    'accessToken' => $accessToken,
    'environment' => Environment::PRODUCTION,
]);

$payments_api = $client->getPaymentsApi();

$money = new Money();
$money->setAmount($amount);
$money->setCurrency($currency);

$payment_body = new CreatePaymentRequest(
    'cnon:card-nonce-ok', // Replace with actual nonce from Square payment form
    uniqid(), // Ensure a unique id per transaction
    $money
);

try {
    $result = $payments_api->createPayment($payment_body);
    if ($result->isSuccess()) {
        header('Location: success.php');
    } else {
        header('Location: error.php');
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    header('Location: error.php');
}
