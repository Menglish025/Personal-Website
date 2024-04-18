document.addEventListener('DOMContentLoaded', function () {
    // Handle clicking on navigation links
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function (event) {
            // Prevent the default anchor behavior
            event.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            
            // Smooth scroll to the target section
            if (targetSection) { // Ensure the element exists before attempting to scroll
                // Smooth scroll to the target section
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                console.error(`No section found with ID ${targetId}`);
            }

            // Update active class on navigation items
            updateActiveClass(this);
        });
    });

    // Load content dynamically (this is just a placeholder and should be replaced with actual content loading logic)
    //loadDynamicContent();
});

function updateActiveClass(activeLink) {
    // Remove the 'active' class from all nav links and add it to the clicked one
    document.querySelectorAll('nav a').forEach(navLink => {
        navLink.classList.remove('active');
    });
    activeLink.classList.add('active');
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
