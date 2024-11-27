function validateForm() {
    let isValid = true;
    clearErrors();

    // Username validation (at least 4 characters)
    const username = document.getElementById('username').value;
    if (username.length < 4) {
        showError('username', 'Username must be at least 4 characters long');
        isValid = false;
    }

    // Password validation (at least 8 characters, includes number and special character)
    const password = document.getElementById('password').value;
    const passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    if (!passwordRegex.test(password)) {
        showError('password', 'Password must be at least 8 characters long and include a number and special character');
        isValid = false;
    }

    // Confirm password
    const confirmPassword = document.getElementById('confirm-password').value;
    if (password !== confirmPassword) {
        showError('confirm-password', 'Passwords do not match');
        isValid = false;
    }

    // Full name validation (only letters and spaces)
    const fullname = document.getElementById('fullname').value;
    const nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(fullname)) {
        showError('fullname', 'Name should contain only letters and spaces');
        isValid = false;
    }

    // Email validation
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('email', 'Please enter a valid email address');
        isValid = false;
    }

    // Phone validation (10 digits)
    const phone = document.getElementById('phone').value;
    const phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone)) {
        showError('phone', 'Please enter a valid 10-digit phone number');
        isValid = false;
    }

    // Address validation (not empty and minimum length)
    const address = document.getElementById('address').value.trim();
    if (address.length < 10) {
        showError('address', 'Please enter a complete address (minimum 10 characters)');
        isValid = false;
    }

    // User type validation
    const userType = document.getElementById('user-type').value;
    if (!userType) {
        showError('user-type', 'Please select an account type');
        isValid = false;
    }

    return isValid;
}

function showError(fieldId, message) {
    const errorElement = document.getElementById(`${fieldId}-error`);
    errorElement.textContent = message;
}

function clearErrors() {
    const errorElements = document.getElementsByClassName('error');
    Array.from(errorElements).forEach(element => {
        element.textContent = '';
    });
}

// Real-time validation
document.getElementById('phone').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 10);
});

document.getElementById('username').addEventListener('input', function() {
    if (this.value.length >= 4) {
        document.getElementById('username-error').textContent = '';
    }
});

document.getElementById('email').addEventListener('input', function() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailRegex.test(this.value)) {
        document.getElementById('email-error').textContent = '';
    }
});