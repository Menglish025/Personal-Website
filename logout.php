<?php
// logout.php
session_start();
if (isset($_SESSION['user_id'])) {
    // If there's a user session, unset and destroy it
    unset($_SESSION['user_id']);
    session_destroy();
}

// Redirect to the sign-in page or home page after logging out
header('Location: sign-in.html');
exit;

