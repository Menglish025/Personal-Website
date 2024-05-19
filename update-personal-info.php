<?php
// update-personal-info.php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$dbname = 'mattjerry0025'; // Database name
$username = 'MattJerry0025'; // Database username
$password = 'Matt@1098'; // Database password

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture and sanitize form data
    $firstName = $conn->real_escape_string($_POST['first_name']);
    $lastName = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $contactNumber = $conn->real_escape_string($_POST['contact_number']);
    
    // Assume $userID is retrieved from session or another secure method
    $userID = $_SESSION['user_id'];

    // Update statement
    $sql = "UPDATE users SET first_name=?, last_name=?, email=?, contact_number=? WHERE id=?";

    // Prepare and bind parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssi", $firstName, $lastName, $email, $contactNumber, $userID);

        // Execute the statement
        if ($stmt->execute()) {
            // Set a session variable to show a success message on the next page
            $_SESSION['success_message'] = "Your personal information has been updated.";
        } else {
            // Set a session variable to show an error message on the next page
            $_SESSION['error_message'] = "Error updating record: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Error preparing statement: " . $conn->error;
    }
    
    // Close connection
    $conn->close();

    // Redirect back to the profile settings page
    header('Location: profile-settings.php');
    exit;
} else {
    // If not a POST request, redirect to the form page
    header('Location: profile-settings.php');
    exit;
}

