<?php
// Start the session to manage user authentication
session_start();

// Include database configuration file
require_once 'config.php';

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit();
}

$message = ''; // Variable to store messages for the user

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $facebookLinked = isset($_POST['facebook_linked']) ? 1 : 0;
    $twitterLinked = isset($_POST['twitter_linked']) ? 1 : 0;
    $googleLinked = isset($_POST['google_linked']) ? 1 : 0;
    $linkedinLinked = isset($_POST['linkedin_linked']) ? 1 : 0;

    // Prepare an update statement
    $sql = "UPDATE users SET facebook_linked=?, twitter_linked=?, google_linked=?, linkedin_linked=? WHERE id=?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iiiii", $facebookLinked, $twitterLinked, $googleLinked, $linkedinLinked, $_SESSION['user_id']);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Check if any social media account details were updated
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Social media accounts updated successfully.";
            } else {
                echo "No changes were made to your social media accounts.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        $message = "Error preparing the query: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);

    // Include a small script to delay redirection
    echo "<script>alert('$message'); window.location.href='profile-settings.html';</script>";
    exit();
}



// Redirect back to settings page or wherever appropriate
header('Location: profile-settings.html');
exit();
