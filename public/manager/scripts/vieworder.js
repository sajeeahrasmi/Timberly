

function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.style.display = 'none');

    // Show the selected section
    document.getElementById(sectionId).style.display = 'block';
}


function goToOrders() {
    // Redirect back to admin.php and show the Orders section
    window.location.href = 'admin.php';
}


