document.addEventListener('DOMContentLoaded', function() {
    var logoutButton = document.querySelector('.logout a');
    var logoutPopup = document.querySelector('.logout-popup');
    var closeButton = document.querySelector('.fa-xmark');

    logoutButton.addEventListener('click', function(event) {
        event.preventDefault();
        logoutPopup.classList.add('show');
    });

    closeButton.addEventListener('click', function() {
        logoutPopup.classList.remove('show');
    });


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