document.querySelectorAll('.order-status').forEach(function(td) {
    if (td.textContent.trim() === 'Delivered') {
        td.style.color = 'green'; // Optional: Change text color for better contrast
    } else if (td.textContent.trim() === 'Awaiting contact designer') {
        td.style.color = 'red'; // Optional: Change text color for better contrast
    }
});