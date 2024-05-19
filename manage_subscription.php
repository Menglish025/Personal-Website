<?php
session_start();
require 'config.php';  // Your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subscription-type'])) {
    $selectedPlan = $_POST['subscription-type'];
    $userId = $_SESSION['user_id'];  // Ensure the user is logged in

    $sql = "UPDATE users SET subscription_plan = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $selectedPlan, $userId);
        $stmt->execute();
        $stmt->close();
        $_SESSION['feedback'] = "Subscription changed to " . $selectedPlan;
        header("Location: membership.php");  // Redirect back to the membership page
        exit();
    } else {
        echo "Error updating subscription: " . $conn->error;
    }
}
?>
