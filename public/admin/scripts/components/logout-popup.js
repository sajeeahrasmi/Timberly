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

    window.addEventListener('click', function(event) {
        if (event.target == logoutPopup) {
            logoutPopup.classList.remove('show');
        }
    });
});