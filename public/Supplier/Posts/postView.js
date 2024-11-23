// function togglePopup(){
//     document.getElementById("popup-1").classList.toggle("active");
    
// }

// Function to toggle the popup window
function togglePopup() {
    const popup = document.getElementById('popup-1');
    popup.classList.toggle('active');
}

// Add event listeners to all the view icons
document.addEventListener('DOMContentLoaded', () => {
    const viewIcons = document.querySelectorAll('.fa-eye');

    viewIcons.forEach(icon => {
        icon.addEventListener('click', () => {
            togglePopup();
        });
    });
});
