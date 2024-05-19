<?php

session_start(); // Always initiate with session_start()

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize the user message variable
$userMessage = "";

// Database configuration
$host = 'localhost'; // Host
$dbname = 'mattjerry0025'; // Database name
$username = 'MattJerry0025'; // Database username
$password = 'Matt@1098'; // Database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare an insert statement
    $sql = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");

    // Check if prepare was successful
    if (!$sql) {
        die('Prepare failed: ' . $conn->error);
    }
    
    // Bind variables to the prepared statement as parameters
    $sql->bind_param("sss", $name, $email, $message);
    
    // Set parameters and execute
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    if ($sql->execute()) {
        // Set the user message into session
        $_SESSION['userMessage'] = "Thank you for your inquiry, we will be in touch shortly and help accomodate or resolve any potential complications.";
    } else {
        $_SESSION['userMessage'] = "Error: " . $sql->error;
    }
    
    // Close statement
    $sql->close();
} else {
    echo 'Request method is not POST';
}

// Close connection
$conn->close();

// Redirect to homepage.php
header('Location: homepage.php');
exit;
