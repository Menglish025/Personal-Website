<?php
// Start the session to manage user authentication
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit();
}

// Include database configuration file
require_once 'config.php';

$updateSuccess = true; // Flag to track overall success of updates

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle password change
    if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmNewPassword = $_POST['confirm_new_password'];

        $sql = "SELECT password_hash FROM users WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $currentPasswordHash);
            if (mysqli_stmt_fetch($stmt)) {
                mysqli_stmt_close($stmt);
                if (password_verify($currentPassword, $currentPasswordHash)) {
                    if ($newPassword === $confirmNewPassword) {
                        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                        $updateSql = "UPDATE users SET password_hash = ? WHERE id = ?";
                        if ($updateStmt = mysqli_prepare($conn, $updateSql)) {
                            mysqli_stmt_bind_param($updateStmt, "si", $newPasswordHash, $_SESSION['user_id']);
                            if (!mysqli_stmt_execute($updateStmt)) {
                                $updateSuccess = false;
                                $_SESSION['feedback'] .= "Failed to update password. ";
                            }
                            mysqli_stmt_close($updateStmt);
                        }
                    } else {
                        $_SESSION['feedback'] .= "New passwords do not match. ";
                        $updateSuccess = false;
                    }
                } else {
                    $_SESSION['feedback'] .= "Current password is incorrect. ";
                    $updateSuccess = false;
                }
            } else {
                $_SESSION['feedback'] .= "Failed to fetch current password. ";
                $updateSuccess = false;
                mysqli_stmt_close($stmt);
            }
        }
    }


    // Handle two-factor authentication preference
    if (isset($_POST['two_factor'])) {
        $twoFactor = $_POST['two_factor'] === 'on' ? 1 : 0; // Convert checkbox to integer

        $updateTwoFactorSql = "UPDATE users SET two_factor_enabled = ? WHERE id = ?";
        if ($twoFactorStmt = mysqli_prepare($conn, $updateTwoFactorSql)) {
            mysqli_stmt_bind_param($twoFactorStmt, "ii", $twoFactor, $_SESSION['user_id']);
            if (!mysqli_stmt_execute($twoFactorStmt)) {
                $updateSuccess = false; // Update failed
            }
            mysqli_stmt_close($twoFactorStmt);
        }
    }

    // Handle security question and answer
    if (!empty($_POST['security_question']) && !empty($_POST['security_answer'])) {
        $securityQuestion = $_POST['security_question'];
        $securityAnswer = $_POST['security_answer'];
        $hashedAnswer = password_hash($securityAnswer, PASSWORD_DEFAULT); // Hash the answer

        $updateSecuritySql = "UPDATE users SET security_question = ?, security_answer = ? WHERE id = ?";
        if ($securityStmt = mysqli_prepare($conn, $updateSecuritySql)) {
            mysqli_stmt_bind_param($securityStmt, "ssi", $securityQuestion, $hashedAnswer, $_SESSION['user_id']);
            if (!mysqli_stmt_execute($securityStmt)) {
                $updateSuccess = false; // Update failed
            }
            mysqli_stmt_close($securityStmt);
        }
    }
} 

// If all updates were successful, redirect to the profile settings page
if ($updateSuccess) {
    $_SESSION['feedback'] .= "All changes saved successfully. ";
    header('Location: profile-settings.php'); // Adjust the URL to your actual profile settings page
    exit();
} else {
    // Not a POST request
    echo "Invalid request.";
}

// Close database connection
mysqli_close($conn);
