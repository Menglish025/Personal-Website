<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
file_put_contents("debug.txt", "Accessed at " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);

// Start session and include database configuration
session_start();
require_once 'config.php';  // Ensure this file has the correct database connection setup


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit();
}


// Function to retrieve the current subscription from the database
function getCurrentSubscription($conn, $userId) {
    $subscription_plan = null; // Initialize the variable to hold the subscription plan
    $sql = "SELECT subscription_plan FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($subscription_plan);
        $stmt->fetch();  // Fetch the subscription plan
        $stmt->close();
    } else {
        // Log and handle errors properly
        error_log("SQL error: " . $stmt->error);
        return false;
    }
    return $subscription_plan;
}

// Retrieve the user's current subscription plan
$user_subscription = getCurrentSubscription($conn, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership - Matt Jerry's Education Hub</title>
    <link rel="stylesheet" href="CSS.css">
</head>
<body>
    <header>
        <?php
            if (isset($_SESSION['feedback'])) {
                echo '<p class="feedback">' . $_SESSION['feedback'] . '</p>';
                unset($_SESSION['feedback']);  // Clear the feedback message session after displaying it
            }
        ?>
                <!-- Header content -->
         <h1>Membership Settings</h1>
         <nav>
             <ul class="nav-list">
                 <li><a href="homepage.php">Home</a></li>
                 <li><a href="courses.php">Courses</a></li>
                 <li><a href="about.html">About Me</a></li>
                 <li><a href="tutorials.php">Video Tutorials</a></li>
                 <li><a href="sign-up.php">Sign Up</a></li>
                 <li><a href="sign-in.php">Sign In</a></li>
             </ul>
         </nav>
    </header>
    
    <main>
        <section id="membership">
            <h2>Membership Details</h2>
            <!-- Content related to membership plans and user subscriptions -->
            <div class="membership-plans">
                <div class="membership-plan">
                    <h3>Basic Plan</h3>
                    <p>Get access to a selection of video tutorials and sample content from our courses.</p>
                    <ul>
                        <li>Access to selected video tutorials</li>
                        <li>Sample content from intricate courses</li>
                        <li>Limited support</li>
                    </ul>
                    <form action="upgrade_plan.php" method="post">
                        <input type="hidden" name="plan" value="basic">
                        <button type="submit">Upgrade to Basic</button>
                    </form>
                </div>
                <div class="membership-plan">
                    <h3>Premium Plan</h3>
                    <p>Unlock the full potential of our platform with access to all video tutorials and intricate courses.</p>
                    <ul>
                        <li>Access to all video tutorials</li>
                        <li>Full access to intricate courses</li>
                        <li>Priority support</li>
                    </ul>
                    <form action="upgrade_plan.php" method="post">
                        <input type="hidden" name="plan" value="premium">
                        <button type="submit">Upgrade to Premium</button>
                    </form>
                </div>
            </div>
            <div class="user-subscription">
                <h3>Your Current Subscription</h3>
                <p>You are currently subscribed to the Premium Plan.</p>
                <button type="submit" onclick="openSubscriptionModal()" style="width:100%;">Manage Subscription</button>
            </div>
            <div class="cancel-subscription">
                <h2>Cancel Subscription</h2>
                <p>If you are not satisfied and wish to cancel your subscription, please click the button below. Note that cancelling your subscription will take effect immediately.</p>
                <button type="submit" onclick="confirmCancel()" style="width:100%;"">Cancel Subscription </button>
            </div>
        </section>

        
    </main>

    <!-- Subscription Management Modal -->
    <div id="subscription-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Manage Subscription</h2>
            <!-- Subscription management form -->
            <form id="subscription-form" action="manage_subscription.php" method="post">
                <label for="subscription-type">Subscription Type:</label>
                <select id="subscription-type" name="subscription-type">
                    <option value="basic">Basic</option>
                    <option value="premium">Premium</option>
                </select>
                <button type="submit">Update Subscription</button>
            </form>
        </div>
    </div>
    
    <footer>
        <p><a href="copyright.html">Copyright © 2024 Matt Jerry</a></p>
        <p><a href="terms.html">Terms Of Service<a/></p>
        <p><a href="privacypolicy.html">Privacy Policy</a></p>
    </footer>
    <script src="Javascript.js"></script>
</body>
</html>