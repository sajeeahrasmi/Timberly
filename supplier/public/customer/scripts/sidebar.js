
document.addEventListener('DOMContentLoaded', function() {
    fetch('/test-current-wrking/components/sidebar.html') 
        .then(response => response.text())
        .then(data => {
            document.getElementById('sidebar').innerHTML = data;
        })
        .catch(error => console.error('Error loading sidebar:', error));
});
