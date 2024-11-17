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
    }
    showSection(sectionId);
}

document.addEventListener('DOMContentLoaded', () => {
    // Check if the function has been executed in this session
    if (!sessionStorage.getItem('dashboardShown')) {
        // Show the dashboard section by default
        showSection('dashboard-section');

        // Mark the function as executed
        sessionStorage.setItem('dashboardShown', 'true');
    }
});