<?php
session_start(); // Start the session at the very beginning

// Check if the session variable for user message is set and display the message
$userMessage = '';
if (isset($_SESSION['userMessage'])) {
    $userMessage = $_SESSION['userMessage'];
    unset($_SESSION['userMessage']); // Unset the variable so it doesn't display again
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matt Jerry's Education Hub</title>
    <link rel="stylesheet" href="CSS.css">
</head>
<body>

    <!-- This is your user message modal, initially hidden -->
    <div id="user-message-modal" class="modal" style="display: none; z-index: 10001;">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <p id="user-message-text"></p>
            </div>
        </div>

    <!-- Display the user message if there is one -->
    <?php if (!empty($userMessage)): ?>
        <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const modal = document.getElementById('user-message-modal');
            const messageText = document.getElementById('user-message-text');
            messageText.textContent = "<?php echo $userMessage; ?>";
            modal.style.display = 'block';
        });
    </script>
    <?php endif; ?>

    <header>
        <h1>Welcome to Matt Jerry's Education Hub</h1>
        <nav>
            <!-- ... Navigation ... -->
            <nav>
            <div class="nav-container">
                <ul class="nav-list">
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="about.html">About Me</a></li>
                    <li><a href="tutorials.php">Video Tutorials</a></li>
                    <li><a href="sign-up.php">Sign Up</a></li>
                    <li><a href="sign-in.php">Sign In</a></li>
                </ul>
            <div class="profile-icon">
                <!-- If user has no profile picture, show default icon -->    
                <a href="#">
                    <img src="default-profile-icon.webp" alt="Profile" id="profileImage">
                </a>
                <div class="dropdown-content">
                    <a href="profile-settings.php">Profile Settings</a>
                    <a href="membership.php">Membership Settings</a>
                    <a href="settings.html">General Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
        </nav>
    </nav>
    </header>

    <main>
        <!-- Intro section -->
        <section class="intro">
            <!-- ... intro content ... -->
            <h2>Explore the World of Mathematics and Computer Science</h2>
            <p>Join me on a journey into the realms of logic and algorithms, and explore the beauty of mathematics and the power of computer programming.</p>
            <a href="courses.html" class="btn">Start Learning</a>
        </section>

        <!-- Courses section -->
        <section id="courses-content">
            <!-- ... courses content ... -->
            <h2>Mathematics and Computer Science Courses</h2>
            <p>Explore our extensive range of courses designed to help you master Mathematics and Computer Science, from beginner to advanced levels.</p>
            <ul>
                <li>Introduction to Programming</li>
                <li>Various Programming Languages:
                <ul>
                    <li>Python</li>
                    <li>HTML</li>
                    <li>CSS</li>
                    <li>JavaScript</li>
                    <li>PHP</li>
                    <li>Java</li>
                    <li>C and C++</li>
                </ul>
                </li>
                <li>Data Structures & Algorithms</li>
                <li>Software Engineering and Optimized SE Practices</li>
                <li>Linear Algebra</li>
                <li>Calculus I, II, III and IV</li>
                <li>Odinary Differential Equations</li>
                <li>Partial Differential Equations</li>
            </ul>
        </section>

        <!-- FAQ section -->
        <section id="faq">
            <!-- ... FAQ content ... -->
            <h2>Frequently Asked Questions</h2>
            <div class="faq-item">
                <h3>How do I purchase a course?</h3>
                <p> Just navigate to the course of your interest and select the "purchase" option.</p>
            </div>
            <div class="faq-item">
                <h3>What is the refund policy?</h3>
                <p>Courses are a singular transaction, intended to enhance the intricate details of a given course; in conjuction with other academic works. Thus, they are rendered as non-refundable.</p>
            </div>
        </div>
        <div class="faq-item">
            <h3>How do I cancel an Intricate Detail membership?</h3>
            <p>Hover over the profile icon with the mouse curser, then select the "Membership Settings" option, from the dropdown menu. Finally, proceed by clicking on the "Cancel Membership" option.</p>
        </div>
        </section>

        <!-- Contact section -->
        <section id="contact">
            <!-- ... contact form ... -->
            <h2>Contact Us</h2>
            <form action="submit-form.php" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
                <button type="submit">Send</button>
            </form>
        </section>
    </main>

    <footer>
        <p><a href="copyright.html" style="color: #ffffff; text-decoration: none;">Copyright © 2024 Matt Jerry</a></p>
        <p><a href="terms.html" style="color: #ffffff; text-decoration: none;">Terms Of Service</a></p>
        <p><a href="privacypolicy.html" style="color: #ffffff; text-decoration: none;">Privacy Policy</a></p>
    </footer>

    <div id="profile-highlight-modal" class="profile-modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Welcome to Matt Jerry's Education Hub!</h2>
            <p>Don't forget to check out your profile settings here!</p>
            <img src="path/to/profile-icon.png" alt="Profile Icon" style="width: 100px; height: auto; display: block; margin: 20px auto;">
        </div>
    </div>



    <script src="Javascript.js"></script>
</body>
</html>
