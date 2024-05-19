<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = htmlspecialchars($_POST['cardNumber']);
    $expiryDate = htmlspecialchars($_POST['expiryDate']);
    $cvv = htmlspecialchars($_POST['cvv']);
    $courseName = htmlspecialchars($_POST['courseName']);
    $price = htmlspecialchars($_POST['price']);

    // Perform validation and process the payment using a gateway (if any)
    // Redirect to success or error page based on payment processing result

    header('Location: success.php');
    exit;
} else {
    die("Invalid request.");
}
