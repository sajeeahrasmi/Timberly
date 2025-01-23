// document.addEventListener("DOMContentLoaded", function() {
//     fetch('/test-current-wrking/components/sidebar.html')
//         .then(response => response.text())
//         .then(data => {
//             document.getElementById("header").innerHTML = data;
//         })
//         .catch(error => console.error('Error loading header:', error));
// });



document.addEventListener('DOMContentLoaded', function() {
    fetch('/Timberly/public/customer/components/header.html') // Adjust the path based on your URL structure
        .then(response => response.text())
        .then(data => {
            document.getElementById('header').innerHTML = data;
        })
        .catch(error => console.error('Error loading header:', error));
});
