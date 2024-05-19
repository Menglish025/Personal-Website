<?php
session_start();
require 'config.php';  // Ensure you have your database connection setup here

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');  // Redirect to login if not logged in
    exit();
}

$userId = $_SESSION['user_id'];  // Get user ID from session

$sql = "UPDATE users SET subscription_plan = 'cancelled' WHERE id = ?";  // Assuming 'cancelled' is a valid status
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
    $_SESSION['feedback'] = "Your membership has been cancelled.";  // Feedback for user
    header("Location: membership.php");  // Redirect back to the membership page
    exit();
} else {
    echo "Error cancelling membership: " . $conn->error;
}
?>
