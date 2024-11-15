function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));

    // Show the selected section
    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.classList.add('active');
    }
}

// Function to check if the current page is index.php
function checkAndShowSection(sectionId) {
    // Get the current page URL
    const currentPage = window.location.pathname.split('/').pop();

    // Check if the current page is index.php
    if (currentPage !== 'index.php') {
        // Redirect to index.php
        window.location.href = 'index.php';
    } else {
        // If on index.php, show the section
        showSection(sectionId);
    }
}

// Placeholder for accept/reject buttons
document.addEventListener('DOMContentLoaded', () => {
    // Show the dashboard section by default
    checkAndShowSection('dashboard-section');
});