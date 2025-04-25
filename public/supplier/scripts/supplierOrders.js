document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const modal = document.getElementById('orderModal');
        const details = document.getElementById('modalDetails');

        // Populate modal details
        details.innerHTML = `
            <p><strong>Post ID:</strong> ${btn.dataset.id}</p>
            <p><strong>Category:</strong> ${btn.dataset.category}</p>
            <p><strong>Type:</strong> ${btn.dataset.type}</p>
            <p><strong>No. of Items:</strong> ${btn.dataset.quantity}</p>
            <p><strong>Date:</strong> ${btn.dataset.date}</p>
            <p><strong>Status:</strong> ${btn.dataset.status}</p>
        `;

        modal.style.display = 'flex'; // Show modal
    });
});

// Close button
document.querySelector('.close-btn').addEventListener('click', () => {
    document.getElementById('orderModal').style.display = 'none';
});

// Optional: Close modal when clicking outside content
window.addEventListener('click', (e) => {
    const modal = document.getElementById('orderModal');
    if (e.target === modal) modal.style.display = 'none';
});