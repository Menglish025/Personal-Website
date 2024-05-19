<?php
// Start the session to manage user authentication
session_start();
error_reporting(E_ALL); // Turn on all errors, warnings, and notices for troubleshooting
ini_set('display_errors', 1);

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.html');
    exit();
}

if (!empty($_SESSION['feedback'])) {
    echo "<div>" . $_SESSION['feedback'] . "</div>";
    unset($_SESSION['feedback']); // Clear the feedback message after displaying it
}

// Include database configuration file
require_once 'config.php';

// Define variables and initialize with empty values
$firstName = $lastName = $email = $contactNumber = "";
$currentPassword = $newPassword = $confirmNewPassword = "";
$twoFactor = $securityQuestion = $securityAnswer = "";
$profileVisibility = $emailUpdates = $smsNotifications = $dataSharing = "";
$emailNotifications = $appNotifications = $socialActivityNotifications = "";
$facebookLinked = $twitterLinked = $googleLinked = $linkedinLinked = "";
$language = $timeZone = "";

function fetchUserData($conn) {
    $data = array('', '', '', '');
    if ($stmt = $conn->prepare("SELECT first_name, last_name, email, contact_number FROM users WHERE id = ?")) {
        $stmt->bind_param("i", $_SESSION['user_id']);
        if ($stmt->execute()) {
            $stmt->bind_result($data[0], $data[1], $data[2], $data[3]);
            if (!$stmt->fetch()) {
                echo "Error fetching user data.";
            }
            $stmt->close();
        } else {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    } else {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    }
    return $data;
}



// Fetch user data initially
list($firstName, $lastName, $email, $contactNumber) = fetchUserData($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['contact_number'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact_number'];

    $sql = "UPDATE users SET first_name=?, last_name=?, email=?, contact_number=? WHERE id=?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $firstName, $lastName, $email, $contactNumber, $_SESSION['user_id']);
        if (mysqli_stmt_execute($stmt)) {
            echo "Personal information updated successfully.";
            list($firstName, $lastName, $email, $contactNumber) = fetchUserData($conn); // Refetch data
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);

    // Account Security Update
    if (isset($_POST['current_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmNewPassword = $_POST['confirm_new_password'];
        $twoFactor = isset($_POST['two_factor']) ? 1 : 0;
        $securityQuestion = $_POST['security_question'];
        $securityAnswer = $_POST['security_answer'];

        if (isset($_POST['current_password'])) {
            // Fetch the current password hash from the database
            $sql = "SELECT password_hash FROM users WHERE id = ?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $currentPasswordHash);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
        
                // Check if the current password matches the hash
                if (password_verify($currentPassword, $currentPasswordHash)) {
                    if ($newPassword === $confirmNewPassword) {
                        // Hash the new password
                        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
                        // Update the password hash in the database
                        $updateSql = "UPDATE users SET password_hash = ? WHERE id = ?";
                        if ($updateStmt = mysqli_prepare($conn, $updateSql)) {
                            mysqli_stmt_bind_param($updateStmt, "si", $newPasswordHash, $_SESSION['user_id']);
                            mysqli_stmt_execute($updateStmt);
                            mysqli_stmt_close($updateStmt);
                            echo "Password updated successfully.";
                        }
                    } else {
                        echo "New passwords do not match.";
                    }
                } else {
                    echo "Current password is incorrect.";
                }
            }
        }

        // Assume you have a column 'two_factor_enabled' in your 'users' table
        $updateTwoFactorSql = "UPDATE users SET two_factor_enabled = ? WHERE id = ?";
        if ($twoFactorStmt = mysqli_prepare($conn, $updateTwoFactorSql)) {
            mysqli_stmt_bind_param($twoFactorStmt, "ii", $twoFactor, $_SESSION['user_id']);
            mysqli_stmt_execute($twoFactorStmt);
            mysqli_stmt_close($twoFactorStmt);
            echo "Two-factor authentication preference updated.";
        }

        // Assume you have columns 'security_question' and 'security_answer' in your 'users' table
        $updateSecuritySql = "UPDATE users SET security_question = ?, security_answer = ? WHERE id = ?";
        if ($securityStmt = mysqli_prepare($conn, $updateSecuritySql)) {
            $hashedAnswer = password_hash($securityAnswer, PASSWORD_DEFAULT); // Hash the security answer
            mysqli_stmt_bind_param($securityStmt, "ssi", $securityQuestion, $hashedAnswer, $_SESSION['user_id']);
            mysqli_stmt_execute($securityStmt);
            mysqli_stmt_close($securityStmt);
            echo "Security question and answer updated.";
        }
    }

    // Privacy Settings Update
    if (isset($_POST['profile_visibility'])) {
        $profileVisibility = $_POST['profile_visibility'];
        $emailUpdates = isset($_POST['email_updates']) ? 1 : 0;
        $smsNotifications = isset($_POST['sms_notifications']) ? 1 : 0;
        $dataSharing = isset($_POST['data_sharing']) ? 1 : 0;

        // Update privacy settings in the database
    }

    // Notification Preferences Update
    if (isset($_POST['email_notifications'])) {
        $emailNotifications = isset($_POST['email_notifications']) ? 1 : 0;
        $appNotifications = isset($_POST['app_notifications']) ? 1 : 0;
        $socialActivityNotifications = isset($_POST['social_activity_notifications']) ? 1 : 0;

        // Update notification settings in the database
    }

    // Linked Accounts Update
    if (isset($_POST['facebook_linked'])) {
        $facebookLinked = isset($_POST['facebook_linked']) ? 1 : 0;
        $twitterLinked = isset($_POST['twitter_linked']) ? 1 : 0;
        $googleLinked = isset($_POST['google_linked']) ? 1 : 0;
        $linkedinLinked = isset($_POST['linkedin_linked']) ? 1 : 0;

        // Update linked accounts status in the database
    }

    // Language and Time Zone Update
    if (isset($_POST['language'])) {
        $language = $_POST['language'];
        $timeZone = $_POST['time_zone'];

        // Update language and time zone settings in the database
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Matt Jerry's Education Hub</title>
    <link rel="stylesheet" href="CSS.css">
</head>
<body>
    <header>
        <!-- Header content --> 
        <h1>Profile Settings</h1>
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

        <?php if (!empty($_SESSION['feedback'])): ?>
            <div id="feedback-message" class="alert alert-success" role="alert">
                <?php
                    echo htmlspecialchars($_SESSION['feedback']);
                    unset($_SESSION['feedback']); // Clear the feedback message after displaying it
                ?>
            </div>
        <?php endif; ?>

        <!-- Include sections similar to the HTML form provided -->
        <section id="personal-info">
            <h2>Personal Information</h2>
            <!-- Form for personal information -->
            <form id="personal-info-form" action="update-personal-info.php" method="post">
                <div class="form-group">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first_name" required value="<?php echo htmlspecialchars($firstName); ?>">
                    </div>

                <div class="form-group">
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last_name" required value="<?php echo htmlspecialchars($lastName); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="form-group">
                    <label for="contact-number">Contact Number:</label>
                    <input type="tel" id="contact-number" name="contact_number" pattern="[0-9]{10}" placeholder="1234567890" required value="<?php echo htmlspecialchars($contactNumber); ?>">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Save Changes</button>
                </div>
            </form>
        </section>
            
        <section id="account-security">
            <h2>Account Security</h2>
            <form id="account-security-form" action="update-security-settings.php" method="post">
                <!-- Password Change -->
                <div class="form-group">
                    <label for="current-password">Current Password:</label>
                    <input type="password" id="current-password" name="current_password" required>
                </div>
                
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new_password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm-new-password">Confirm New Password:</label>
                    <input type="password" id="confirm-new-password" name="confirm_new_password" required>
                </div>
        
                <!-- Two-Factor Authentication Toggle -->
                <div class="form-group">
                    <label for="two-factor">Two-Factor Authentication:</label>
                    <input type="checkbox" id="two-factor" name="two_factor">
                    <span>Enable for an extra layer of security</span>
                </div>
        
                <!-- Security Questions -->
                <div class="form-group">
                    <label for="security-question">Security Question:</label>
                    <select id="security-question" name="security_question">
                        <option value="pet_name">What is the name of your first pet?</option>
                        <option value="mother_maiden_name">What is your mother's maiden name?</option>
                        <option value="first_car">What was the make and model of your first car?</option>
                        <!-- Additional security questions can be added here -->
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="security-answer">Answer:</label>
                    <input type="text" id="security-answer" name="security_answer" required>
                </div>
        
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn">Update Security Settings</button>
                </div>
            </form>
        </section>    
            
        <section id="privacy-settings">
            <h2>Privacy Settings</h2>
            <form id="privacy-settings-form" action="update-privacy-settings.php" method="post">
                <!-- Profile Visibility -->
                <div class="form-group">
                    <label for="profile-visibility">Profile Visibility:</label>
                    <select id="profile-visibility" name="profile_visibility">
                        <option value="public">Public</option>
                        <option value="friends">Friends Only</option>
                        <option value="private">Private</option>
                    </select>
                </div>
        
                <!-- Communication Preferences -->
                <div class="form-group">
                    <label for="email-updates">Email Updates:</label>
                    <input type="checkbox" id="email-updates" name="email_updates" checked>
                    <span>Receive updates and newsletters by email</span>
                </div>
        
                <div class="form-group">
                    <label for="sms-notifications">SMS Notifications:</label>
                    <input type="checkbox" id="sms-notifications" name="sms_notifications">
                    <span>Receive SMS notifications for new activity</span>
                </div>
        
                <!-- Data Sharing Options -->
                <div class="form-group">
                    <label for="data-sharing">Data Sharing with Third Parties:</label>
                    <input type="checkbox" id="data-sharing" name="data_sharing">
                    <span>Allow sharing of anonymized data with third parties for research</span>
                </div>
        
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn">Save Privacy Settings</button>
                </div>
            </form>
        </section>
            
            
        <section id="notification-preferences">
            <h2>Notification Preferences</h2>
            <form id="notification-preferences-form" action="update-notification-preferences.php" method="post">
                <!-- Email Notifications -->
                <div class="form-group">
                    <label for="email-notifications">Email Notifications:</label>
                    <input type="checkbox" id="email-notifications" name="email_notifications" checked>
                    <span>Receive email notifications for new messages and alerts</span>
                </div>
        
                <!-- App Notifications -->
                <div class="form-group">
                    <label for="app-notifications">App Notifications:</label>
                    <input type="checkbox" id="app-notifications" name="app_notifications" checked>
                    <span>Receive push notifications on your device</span>
                </div>
        
                <!-- Text Messages -->
                <div class="form-group">
                    <label for="sms-notifications">Text Message Notifications:</label>
                    <input type="checkbox" id="sms-notifications" name="sms_notifications">
                    <span>Receive text message notifications for urgent updates</span>
                </div>
        
                <!-- Social Activity -->
                <div class="form-group">
                    <label for="social-activity-notifications">Social Activity:</label>
                    <input type="checkbox" id="social-activity-notifications" name="social_activity_notifications">
                    <span>Receive notifications about new social activities and friend requests</span>
                </div>
        
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn">Save Notification Preferences</button>
                </div>
            </form>
        </section>
            

        <section id="linked-accounts">
            <h2>Linked Accounts</h2>
            <!-- Form action typically would be to a backend script that handles the unlinking process -->
            <form id="linked-accounts-form" action="update-linked-accounts.php" method="post">
                <!-- Linked Social Media Accounts -->
                <div class="form-group">
                    <label>Facebook:</label>
                    <input type="checkbox" id="facebook-linked" name="facebook_linked" disabled>
                    <button type="button" class="btn" onclick="manageLink('facebook', 'http://link-to-facebook.com');">Link Facebook</button>
                </div>

                <div class="form-group">
                    <label>Twitter:</label>
                    <input type="checkbox" id="twitter-linked" name="twitter_linked" disabled>
                    <button type="button" class="btn" onclick="manageLink('twitter', 'http://link-to-twitter.com');">Link Twitter</button>
                </div>

                <div class="form-group">
                    <label>Google:</label>
                    <input type="checkbox" id="google-linked" name="google_linked" disabled>
                    <button type="button" class="btn" onclick="manageLink('google', 'http://link-to-google.com');">Link Google</button>
                </div>

                <div class="form-group">
                    <label>LinkedIn:</label>
                    <input type="checkbox" id="linkedin-linked" name="linkedin_linked" disabled>
                    <button type="button" class="btn" onclick="manageLink('linkedin', 'http://link-to-linkedin.com');">Link LinkedIn</button>
                </div>

                <!-- Save Changes Button -->
                <div class="form-group">
                    <button type="submit" class="btn">Save Changes</button>
                </div>
            </form>
        </section>


        
        
        <section id="language-timezone-settings">
            <h2>Language and Time Zone</h2>
            <form id="language-timezone-form" action="update-language-timezone.php" method="post">
                <!-- Language Selection -->
                <div class="form-group">
                    <label for="language-select">Language:</label>
                    <select id="language-select" name="language">
                        <option value="en">English</option>
                        <option value="es">Spanish</option>
                        <option value="fr">French</option>
                        <option value="de">German</option>
                        <!-- Add other languages as needed -->
                    </select>
                </div>
        
                <!-- Time Zone Selection -->
                <div class="form-group">
                    <label for="timezone-select">Time Zone:</label>
                    <select id="timezone-select" name="time_zone">
                        <option value="Etc/GMT+12">(GMT-12:00) International Date Line West</option>
                            <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                            <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
                            <option value="America/Anchorage">(GMT-09:00) Alaska</option>
                            <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                            <option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California</option>
                            <option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
                            <option value="America/Phoenix">(GMT-07:00) Arizona</option>
                            <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                            <option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
                            <option value="America/Regina">(GMT-06:00) Saskatchewan</option>
                            <option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                            <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                            <option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
                            <option value="America/Indiana/Indianapolis">(GMT-05:00) Indiana (East)</option>
                            <option value="America/Halifax">(GMT-04:00) Atlantic Time (Canada)</option>
                            <option value="America/Caracas">(GMT-04:00) Caracas, La Paz</option>
                            <option value="America/Santiago">(GMT-04:00) Santiago</option>
                            <option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                            <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                            <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires, Georgetown</option>
                            <option value="America/Godthab">(GMT-03:00) Greenland</option>
                            <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                            <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                            <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                            <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                            <option value="Africa/Casablanca">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
                            <option value="Etc/Greenwich">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                            <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                            <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                            <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                            <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                            <option value="Africa/Lagos">(GMT+01:00) West Central Africa</option>
                            <option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>
                            <option value="Asia/Amman">(GMT+02:00) Amman</option>
                            <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                            <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                            <option value="Asia/Damascus">(GMT+02:00) Damascus</option>
                            <option value="Asia/Gaza">(GMT+02:00) Gaza</option>
                            <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                            <option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>
                            <option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kiev, Riga, Sofia, Tallinn, Vilnius</option>
                            <option value="Asia/Baghdad">(GMT+03:00) Baghdad</option>
                            <option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh</option>
                            <option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>
                            <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                            <option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>
                            <option value="Asia/Baku">(GMT+04:00) Baku</option>
                            <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                            <option value="Asia/Tbilisi">(GMT+04:00) Tbilisi</option>
                            <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
                            <option value="Asia/Yekaterinburg">(GMT+05:00) Yekaterinburg</option>
                            <option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
                            <option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                            <option value="Asia/Calcutta">(GMT+05:30) Sri Jayawardenapura</option>
                            <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                            <option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>
                            <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                            <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                            <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                            <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                            <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                            <option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur, Singapore</option>
                            <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                            <option value="Australia/Perth">(GMT+08:00) Perth</option>
                            <option value="Asia/Taipei">(GMT+08:00) Taipei</option>
                            <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                            <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                            <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                            <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                            <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                            <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                            <option value="Australia/Canberra">(GMT+10:00) Canberra, Melbourne, Sydney</option>
                            <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                            <option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>
                            <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                            <option value="Asia/Magadan">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                            <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                            <option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                            <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>

                    </select>
                </div>
        
                <!-- Save Changes Button -->
                <div class="form-group">
                    <button type="submit" class="btn">Save Changes</button>
                </div>
            </form>
        </section>
            
        
        
        <section id="account-management">
            <h2>Account Management</h2>
            <!-- Buttons to trigger modal dialogs -->
            <div class="form-group actions">
                <button type="button" class="btn" onclick="openModal('deactivate-account-modal');">Deactivate Account</button>
                <button type="button" class="btn" onclick="openModal('delete-account-modal');">Delete Account</button>
            </div>

            <!-- Modal for account deactivation confirmation -->
            <div id="deactivate-account-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Deactivate Account</h2>
                    <p>Are you sure you want to deactivate your account?</p>
                    <div class="btn-container">
                        <button id="confirm-deactivate" class="btn">Yes, Deactivate</button>
                        <button id="cancel-deactivate" class="btn cancel">Cancel</button>
                    </div>
                </div>
            </div>

            <!-- Modal for account deletion confirmation -->
            <div id="delete-account-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Delete Account</h2>
                    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                    <div class="btn-container">
                        <button id="confirm-delete" class="btn">Yes, Delete</button>
                        <button id="cancel-delete" class="btn cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <footer>
        <!-- Footer content -->
    </footer>
    <script src="Javascript.js"></script>
</body>
</html>
