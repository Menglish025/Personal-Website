<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
require 'config.php';  // Ensure you have your database connection setup here

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['plan'])) {
    $newPlan = $_POST['plan'];
    $userId = $_SESSION['user_id'];  // Ensure user is logged in

    $sql = "UPDATE users SET subscription_plan = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $newPlan, $userId);
        if ($stmt->execute()) {
            header("Location: membership.php");  // Redirect back to the membership page
            exit();
        } else {
            echo "Error executing update: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    
}

