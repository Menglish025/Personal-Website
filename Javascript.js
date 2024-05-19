document.addEventListener('DOMContentLoaded', function () {
    // Handle clicking on navigation links
    document.querySelectorAll('nav a').forEach(link => {
        const targetId = link.getAttribute('href').substring(1);
        // Only prevent default if there is an element with the target ID
        if (document.getElementById(targetId)) {
            link.addEventListener('click', function (event) {
                // Prevent the default anchor behavior
                event.preventDefault();

                const targetSection = document.getElementById(targetId);
                // Smooth scroll to the target section
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });

                // Update active class on navigation items
                updateActiveClass(this);
            });
        }
    });

    // Attach event listener to manage subscription button
    const manageSubscriptionBtn = document.querySelector('.manage-subscription button');
    if (manageSubscriptionBtn) {
        manageSubscriptionBtn.addEventListener('click', openSubscriptionModal);
    }
});

function updateActiveClass(activeLink) {
    // Remove the 'active' class from all nav links and add it to the clicked one
    document.querySelectorAll('nav a').forEach(navLink => {
        navLink.classList.remove('active');
    });
    activeLink.classList.add('active');
}

function openSubscriptionModal() {
    var modal = document.getElementById('subscription-modal');
    if (modal) {
        modal.style.display = 'block';
        var closeBtn = modal.querySelector('.close');
        if (closeBtn) {
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            }
        } else {
            console.log('Close button not found.');
        }
    } else {
        console.log('Modal not found.');
    }
}

function loadDynamicContent() {
    // Placeholder function for loading content dynamically
    // Fetch content from a server or another source and inject it into the DOM

    // Example for Courses section
    const coursesSection = document.getElementById('courses');
    coursesSection.innerHTML += '<p>List of courses coming soon...</p>'; // Replace with actual content fetching

    // Example for Video Tutorials section
    const tutorialsSection = document.getElementById('tutorials');
    tutorialsSection.innerHTML += '<p>Check back soon for video tutorials.</p>'; // Replace with actual content fetching
}


  
  function updateColorsBasedOnMode(isDarkMode) {
    // Logic to update text colors based on the mode
    const navLinks = document.querySelectorAll('nav ul li a');
    if (isDarkMode) {
      navLinks.forEach(link => link.style.color = 'purple');
    } else {
      navLinks.forEach(link => link.style.color = '#2196F3');
    }
  }

// Toggle dark mode across the site and save the preference
function toggleDarkMode(activate) {
    document.body.classList.toggle('dark-mode', activate);
    localStorage.setItem('darkMode', activate);
}

// Apply the dark mode setting when loading any page
function applyDarkModeSetting() {
    const isDarkModeEnabled = localStorage.getItem('darkMode') === 'true';
    document.body.classList.toggle('dark-mode', isDarkModeEnabled);
    const darkModeSwitch = document.getElementById('dark-mode');
    if (darkModeSwitch) {
        darkModeSwitch.checked = isDarkModeEnabled;
    }
}

// Update link colors based on the current mode
function updateLinkColors(isDarkMode) {
    const navLinks = document.querySelectorAll('nav ul li a');
    navLinks.forEach(link => {
        link.style.color = isDarkMode ? 'purple' : '#2196F3';
    });
}

// Event listeners when the document is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Apply dark mode based on the saved setting
    applyDarkModeSetting();

    // Set up the dark mode toggle switch
    const darkModeSwitch = document.getElementById('dark-mode');
    if (darkModeSwitch) {
        darkModeSwitch.addEventListener('change', function () {
            toggleDarkMode(darkModeSwitch.checked);
            updateLinkColors(darkModeSwitch.checked);
        });
    }

    // Event delegation for handling all click events in the account management section
    document.querySelector('#account-management').addEventListener('click', function(event) {
        if (event.target.id === 'open-deactivate-modal') {
            showModal('deactivate-account-modal');
        } else if (event.target.id === 'open-delete-modal') {
            showModal('delete-account-modal');
        } else if (event.target.classList.contains('close-modal')) {
            // This assumes your close button has a class 'close-modal'
            hideModal(event.target.closest('.modal'));
        }
    });

    // Event delegation for handling all click events outside of modals to close them
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            hideModal(event.target);
        }
    });

    // Handle the save settings button click
    const saveSettingsButton = document.querySelector('#settings-form .btn');
    if (saveSettingsButton) {
        saveSettingsButton.addEventListener('click', function (event) {
            event.preventDefault();
            toggleDarkMode(darkModeSwitch.checked);
            // Notify the user that settings have been saved
            alert('Settings have been saved.');
        });
    }

    // Handle navigation link clicks for smooth scrolling
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function (event) {
            // Smooth scrolling logic here if needed
        });
    });
});

function linkAccount(platform) {
    // Logic to link a social media account
    // Typically, this would involve redirecting to the platform's OAuth URL or opening a popup
    console.log('Linking:', platform);
    // Replace with actual linking logic
}

// You may want to add scripts to dynamically set the selected options based on user's current settings
document.addEventListener('DOMContentLoaded', function() {
    // Fetch and set the current user's language and time zone
    fetchCurrentUserSettings();
});

function fetchCurrentUserSettings() {
    // Placeholder for fetching user settings from the server
    // Example: Set the selected value based on the user's settings
    document.getElementById('language-select').value = 'en'; // Assume the user's language is English
    document.getElementById('timezone-select').value = 'UTC+00:00'; // Assume the user's time zone is GMT
}

// Attach event listener to form submission
document.getElementById('language-timezone-form').addEventListener('submit', function(event) {
    event.preventDefault();
    // Logic to update the user's language and time zone
    const selectedLanguage = document.getElementById('language-select').value;
    const selectedTimeZone = document.getElementById('timezone-select').value;
    console.log('Saving language:', selectedLanguage, 'Time Zone:', selectedTimeZone);
    // Replace with actual update logic
});


document.addEventListener('DOMContentLoaded', function() {
    const deactivateAccountModal = document.getElementById('deactivate-account-modal');
    const deleteAccountModal = document.getElementById('delete-account-modal');
    const confirmDeactivateBtn = document.getElementById('confirm-deactivate');
    const cancelDeactivateBtn = document.getElementById('cancel-deactivate');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const closeDeactivateBtn = document.querySelector('#deactivate-account-modal .close');
    const closeDeleteBtn = document.querySelector('#delete-account-modal .close');

    // Function to open the deactivate account modal
    function openDeactivateModal() {
        deactivateAccountModal.style.display = 'flex';
    }

    // Function to open the delete account modal
    function openDeleteModal() {
        deleteAccountModal.style.display = 'flex';
    }

    // Function to close the modals
    function closeModal(modal) {
        modal.style.display = 'none';
    }

    // Attach event listeners to open modals
    const deactivateAccountBtn = document.querySelector('#account-management .actions button:nth-child(1)');
    const deleteAccountBtn = document.querySelector('#account-management .actions button:nth-child(2)');
    deactivateAccountBtn.addEventListener('click', openDeactivateModal);
    deleteAccountBtn.addEventListener('click', openDeleteModal);

    // Attach event listeners to close modals
    cancelDeactivateBtn.addEventListener('click', function() {
        closeModal(deactivateAccountModal);
    });
    cancelDeleteBtn.addEventListener('click', function() {
        closeModal(deleteAccountModal);
    });
    closeDeactivateBtn.addEventListener('click', function() {
        closeModal(deactivateAccountModal);
    });
    closeDeleteBtn.addEventListener('click', function() {
        closeModal(deleteAccountModal);
    });

    // Functionality for confirmation buttons
    confirmDeactivateBtn.addEventListener('click', function() {
        // Perform the deactivation action here
        alert("Your account has been deactivated."); // Replace this with actual deactivation logic
        closeModal(deactivateAccountModal);
    });

    confirmDeleteBtn.addEventListener('click', function() {
        // Perform the deletion action here
        alert("Your account has been deleted."); // Replace this with actual deletion logic
        closeModal(deleteAccountModal);
    });
});

function submitContactForm(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(event.target); // Get the form data

    fetch('submit-form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Display the message to the user
        var userMessageDiv = document.createElement('div');
        userMessageDiv.classList.add('user-message');
        userMessageDiv.textContent = data;
        document.body.insertBefore(userMessageDiv, document.body.firstChild);

        // Optionally, scroll to top to ensure user sees the message
        window.scrollTo(0, 0);

        // Clear the form
        event.target.reset();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Attach the event listener to the form
document.querySelector('#contact form').addEventListener('submit', submitContactForm);

document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('user-message-modal');
    var span = document.getElementsByClassName('close-button')[0]; // Gets the first element
  
    span.onclick = function() {
      modal.style.display = 'none';
    };
  
    window.onclick = function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    };
  
    // Show the modal with user message if it exists
    var userMessage = "<?php echo addslashes($userMessage); ?>";
    if (userMessage) {
      document.getElementById('user-message-text').innerText = userMessage;
      modal.style.display = 'flex'; // Use flex here to enable the flexbox CSS to center the modal
    }
});
  
function showModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex'; // Make sure your CSS sets modals to be centered when using flex
    }
}

function hideModal(modal) {
    if (modal) {
        modal.style.display = 'none';
    }
}

function linkAccount(accountCheckboxId) {
    // Placeholder functionality for linking account
    var checkbox = document.getElementById(accountCheckboxId);
    if (!checkbox.checked) {
        // Simulate an API call to link the account
        console.log('Linking account...');
        // After successful linking, set the checkbox to checked
        checkbox.checked = true;
    } else {
        // Simulate an API call to unlink the account
        console.log('Unlinking account...');
        // After successful unlinking, set the checkbox to unchecked
        checkbox.checked = false;
    }
}

function manageLink(platform, linkUrl) {
    // Check if already linked, for example by checking the checkbox status or another indicator.
    // This part needs to be integrated with your backend to know if the account is linked or not.

    // Simulate linking process
    if (confirm('Do you want to link your ' + platform + ' account?')) {
        window.open(linkUrl, '_blank'); // This will open the link in a new tab
    }
}


function startOAuthProcess(platform) {
    var oauthUrl = '';
    var client_id = 'YOUR_CLIENT_ID';
    var redirect_uri = encodeURIComponent('YOUR_CALLBACK_URL');
    
    if(platform === 'facebook') {
        oauthUrl = 'https://www.facebook.com/dialog/oauth?client_id=' + client_id + '&redirect_uri=' + redirect_uri + '&scope=email,public_profile';
    } else if(platform === 'twitter') {
        // Twitter uses OAuth 1.0 which has a different flow, this is just a placeholder
        oauthUrl = 'https://api.twitter.com/oauth/authenticate';
    } else if(platform === 'google') {
        oauthUrl = 'https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=' + client_id + '&redirect_uri=' + redirect_uri + '&scope=profile email';
    } else if(platform === 'linkedin') {
        oauthUrl = 'https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' + client_id + '&redirect_uri=' + redirect_uri + '&scope=r_liteprofile%20r_emailaddress';
    }
    
    if(oauthUrl) {
        window.location.href = oauthUrl; // This will redirect the user to the OAuth page
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('profile-highlight-modal');
    var closeButton = document.querySelector('.close-button');
    
    // Display the modal
    modal.style.display = "block";
    
    // Close the modal when the close button is clicked
    closeButton.onclick = function() {
        modal.style.display = "none";
    };
    
    // Close the modal if the user clicks anywhere outside of the modal content
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
});

function confirmCancel() {
    if (confirm("Are you sure you want to cancel your membership?")) {
        fetch('cancel_subscription.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=cancel'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if(data.success) {
                // Optionally redirect or update the UI
                window.location.href = 'homepage.php';
            }
        })
        .catch(error => console.error('Error:', error));
    }
}


function purchaseCourse(courseName, price) {
    // Confirm with the user before proceeding
    const userConfirmed = confirm(`Are you sure you want to purchase the ${courseName} course for $${price}?`);

    if (userConfirmed) {
        // Display a thank you message
        alert(`Thank you for purchasing the ${courseName} course for $${price}!`);

        // Here, you might want to integrate with a payment gateway
        // For example, redirecting to a checkout page or handling the transaction via API.
        // This is a simple simulation of such a process:

        // Redirect to a payment page (this URL would be specific to your payment gateway setup)
        window.location.href = `checkout.php?courseName=${encodeURIComponent(courseName)}&price=${price}`;

        // Alternatively, if using a front-end framework or if you have a cart system:
        // addToCart(courseName, price); // This would be a function that handles adding the course to a session or database

        // Note: Ensure proper backend validation and security measures in place for actual implementation.
    } else {
        // If the user cancels, you might want to log this event or simply alert them.
        console.log('Purchase cancelled.');
    }
}
