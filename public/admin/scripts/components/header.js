// header.js
document.addEventListener("DOMContentLoaded", function() {
    fetch("header.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("header").innerHTML = data;
        })
        .catch(error => console.error('Error loading header:', error));
});
