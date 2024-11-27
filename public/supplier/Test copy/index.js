
// Toggle popup visibility
// function togglePopup() {
//     const popup = document.getElementById('notificationPopup');
//     popup.classList.toggle('active');
// }

// Redirect to the notification details page
function viewNotification() {
    window.location.href = 'view-post.html'; // Replace with the actual URL
}

// Handle the back button functionality
function goBack() {
    window.history.back();
}

// Add event listener to the dashboard notification button
document.getElementById('dashboardNotificationBtn').addEventListener('click', () => {
    togglePopup();
});
