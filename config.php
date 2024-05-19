<?php
$host = 'localhost';  // Or the appropriate hostname
$dbname = 'mattjerry0025';  // Your database name
$username = 'MattJerry0025';  // Your database username
$password = 'Matt@1098';  // Your database password

// config.php
define('STRIPE_KEY', 'your_stripe_api_key');
define('PAYPAL_CLIENT_ID', 'your_paypal_client_id');
define('PAYPAL_SECRET', 'your_paypal_secret');
define('SQUARE_ACCESS_TOKEN', 'your_square_access_token');

// Create connection using mysqli
$conn = new mysqli($host, $username, $password, $dbname);  // Use $dbname here

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // It's good practice not to echo out connection success messages in production code
    // echo 'Connection successful!';
}




