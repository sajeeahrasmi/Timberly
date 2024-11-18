

function showSection(sectionId) {
    
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.style.display = 'none');

    
    document.getElementById(sectionId).style.display = 'block';
}


function goToOrders() {
    
    window.location.href = 'admin.php';
}


