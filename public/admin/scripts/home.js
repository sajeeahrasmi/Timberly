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
  
// Placeholder for accept/reject buttons
document.addEventListener('DOMContentLoaded', () => {
    // Show the dashboard section by default
    showSection('dashboard-section');
})