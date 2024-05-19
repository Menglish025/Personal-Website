<?php

require 'vendor/autoload.php';

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Exception\PayPalConnectionException;

$amount = 100; // Example amount, replace with actual amount
$currency = 'USD'; // Example currency, replace with actual currency

$provider = new ApiContext(
    new OAuthTokenCredential(
        'PAYPAL_CLIENT_ID', // Replace with your actual PayPal client ID
        'PAYPAL_SECRET'     // Replace with your actual PayPal secret
    )
);

$payment = new Payment();
$payment->setIntent('sale')
    ->setPayer(new Payer(['payment_method' => 'paypal']))
    ->setTransactions([
        new Transaction([
            'amount' => [
                'total' => $amount,
                'currency' => $currency
            ],
            'description' => 'Premium Membership'
        ])
    ])
    ->setRedirectUrls(new RedirectUrls([
        'return_url' => 'https://yourdomain.com/success.php',
        'cancel_url' => 'https://yourdomain.com/cancel.php'
    ]));

try {
    $payment->create($provider);
    header("Location: " . $payment->getApprovalLink());
} catch (PayPalConnectionException $e) {
    error_log($e->getData());
    echo "An error occurred. Please try again later.";
}
