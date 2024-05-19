<?php
// Include the database configuration file if it's external
require_once 'config.php';  // Ensure config.php returns a $conn variable with the database connection

session_start();
require 'db.php'; // Include your database connection

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from POST
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate input and check if passwords match, etc.
    if ($password !== $confirm_password) {
        // Handle the error, maybe set a flash message or similar
        exit('Passwords do not match.');
    }

    // Check if the username or email already exists
    $query = "SELECT COUNT(*) FROM users WHERE username=? OR email=?";
    if ($existsQuery = $conn->prepare($query)) {
        $existsQuery->bind_param("ss", $username, $email);
        $existsQuery->execute();
        $result = $existsQuery->get_result(); // Get the result set from the prepared statement
        $row = $result->fetch_array(MYSQLI_NUM);
        if ($row[0] > 0) {
            exit('Username or Email already exists.');
        }
    } else {
        exit('Query preparation failed: ' . $conn->error);
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $insertQuery = "INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($insertQuery)) {
        $stmt->bind_param("sss", $username, $password_hash, $email);
        if ($stmt->execute()) {
            // Redirect to login page or somewhere else
            header('Location: login.php'); // Adjust the redirect as necessary
            exit();
        } else {
            exit('Insert query execution failed: ' . $stmt->error);
        }
    } else {
        exit('Insert query preparation failed: ' . $conn->error);
    }
} else {
    // Redirect back to the signup form or show an error
    header('Location: signup.php'); // Adjust the redirect as necessary
    exit();
}

