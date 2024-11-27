

function showEditMode() {
    document.getElementById('viewProfile').style.display = 'none';
    document.getElementById('editProfile').style.display = 'block';

    // Pre-fill form with current values
    const currentEmail = document.querySelector('.profile-info span:nth-of-type(3)').textContent;
    const currentPhone = document.querySelector('.profile-info span:nth-of-type(4)').textContent;
    const currentAddress = document.querySelector('.profile-info span:nth-of-type(5)').textContent;

    document.getElementById('email').value = currentEmail;
    document.getElementById('phone').value = currentPhone;
    document.getElementById('address').value = currentAddress;
}

function cancelEdit() {
    document.getElementById('viewProfile').style.display = 'block';
    document.getElementById('editProfile').style.display = 'none';
}

function updateProfile(event) {
    event.preventDefault();

    // Get updated values
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;

    // Update the view mode with new values
    document.querySelector('.profile-info span:nth-of-type(3)').textContent = email;
    document.querySelector('.profile-info span:nth-of-type(4)').textContent = phone;
    document.querySelector('.profile-info span:nth-of-type(5)').textContent = address;

    // Show success message
    alert('Profile updated successfully!');

    // Switch back to view mode
    cancelEdit();
}