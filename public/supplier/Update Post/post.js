// Wait for the DOM to fully load
document.addEventListener('DOMContentLoaded', () => {
    // Get references to the buttons
    const timberButton = document.querySelector('.buttons button:nth-child(1)');
    const lumberButton = document.querySelector('.buttons button:nth-child(2)');

    // Add event listeners to each button
    timberButton.addEventListener('click', () => {
        window.location.href = '../Create Post/timber.html'; // Redirect to the Timber page
    });

    lumberButton.addEventListener('click', () => {
        window.location.href = '../Create Post/lumber.html'; // Redirect to the Lumber page
    });
});
