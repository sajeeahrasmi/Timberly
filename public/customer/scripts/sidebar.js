
document.addEventListener('DOMContentLoaded', function() {
    fetch('/Timberly/public/customer/components/sidebar.html') 
        .then(response => response.text())
        .then(data => {
            document.getElementById('sidebar').innerHTML = data;
        })
        .catch(error => console.error('Error loading sidebar:', error));
});
