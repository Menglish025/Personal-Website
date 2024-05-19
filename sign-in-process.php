<?php
// Start the session at the very beginning
session_start();
require_once 'config.php'; // Include the $conn variable for database connection

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user by username
    if ($stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username=?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        
        if ($user = $result->fetch_assoc()) {
            // User found, verify password
            if (password_verify($password, $user['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                // Redirect to the user's dashboard or homepage
                header('Location: homepage.php');
                exit();
            } else {
                // Password does not match
                $_SESSION['login_error'] = "Invalid password.";
                header('Location: sign-in.php');
                exit();
            }
        } else {
            // User not found
            $_SESSION['login_error'] = "User does not exist.";
            header('Location: sign-in.php');
            exit();
        }
    }
}






