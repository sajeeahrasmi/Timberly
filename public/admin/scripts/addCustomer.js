document.getElementById("uploadImage").addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("profileImage").src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

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
        // Redirect to index.php with a query parameter to indicate the section
        window.location.href = `index.php?section=${sectionId}`;
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