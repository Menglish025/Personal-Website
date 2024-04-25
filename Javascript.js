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
    const subscriptionModal = document.getElementById('subscription-modal');
    if (subscriptionModal) {
        subscriptionModal.style.display = 'block';
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
        deactivateAccountModal.style.display = 'block';
    }

    // Function to open the delete account modal
    function openDeleteModal() {
        deleteAccountModal.style.display = 'block';
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
