<?php
// Assume connection to database is already established in $conn

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user by username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        // User found, verify password
        if (password_verify($password, $user['password_hash'])) {
            // Start session, set session variables
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to user dashboard or send a success response
            echo "Login successful!";
        } else {
            // Password does not match
            echo "Invalid credentials.";
        }
    } else {
        // User not found
        echo "User does not exist.";
    }
}

