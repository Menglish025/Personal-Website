<?php

require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('YOUR_STRIPE_SECRET_KEY'); // Replace with your actual Stripe secret key

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = htmlspecialchars($_POST['stripeToken']);
    $courseName = htmlspecialchars($_POST['courseName']);
    $price = htmlspecialchars($_POST['price']);

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $price * 100, // Stripe expects amount in cents
            'currency' => 'USD', // Replace with the correct currency code if needed
            'description' => $courseName,
            'source' => $token,
        ]);

        header('Location: success.php');
        exit;
    } catch (Exception $e) {
        error_log($e->getMessage());
        header('Location: error.php');
        exit;
    }
} else {
    die("Invalid request.");
}
