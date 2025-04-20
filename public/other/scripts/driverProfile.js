function showEditMode() {
    document.getElementById('viewProfile').style.display = 'none';
    document.getElementById('editProfile').style.display = 'block';
}

function cancelEdit() {
    document.getElementById('viewProfile').style.display = 'block';
    document.getElementById('editProfile').style.display = 'none';
}

function updateProfile(event) {
    event.preventDefault();

    const userId = document.getElementById('userId').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;

    const data = { userId, email, phone, address };

    // Log data to check it
    console.log(data);

    fetch('updateDriverProfile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Profile updated successfully!");
            // Update the profile info on the page
            document.querySelector("#viewProfile span:nth-child(1)").innerText = email;
            document.querySelector("#viewProfile span:nth-child(2)").innerText = phone;
            document.querySelector("#viewProfile span:nth-child(3)").innerText = address;

            // Redirect to profile page after successful update
            window.location.href = "driverProfile.php";  // Adjust the redirect to the correct URL if needed
        } else {
            alert(data.error || "An error occurred while updating the profile.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the profile.');
    });
}
