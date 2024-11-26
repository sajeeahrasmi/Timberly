document.getElementById("uploadImage").addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("profileImage").src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

const submitButton = document.querySelector('.add-driver-form button[type="submit"]');
submitButton.addEventListener('click', (event) => {
    event.preventDefault(); 

    const form = document.getElementById('add-driver-form');

    if (form.reportValidity()) {
        confirmSubmit(form);
    }
});

function validateForm() {
    const profileImage = document.getElementById('uploadImage').value;
    const name = document.getElementById('name').value.trim();
    const vehicleNo = document.getElementById('vehicleNo').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    const nic = document.getElementById('nic').value.trim();

   
    if (profileImage === '') {
        alert("Please upload the image.");
        return false;
    }

    if (name === '') {
        alert("Please enter the name.");
        return false;
    }

    if (vehicleNo === '') {
        alert("Please enter the vehicle number.");
        return false;
    }

    if (nic === '') {
        alert("Please enter the NIC.");
        return false;
    }

    if (email === '') {
        alert("Please enter the email.");
        return false;
    }
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (phone === '') {
        alert("Please enter the phone number.");
        return false;
    }
    const phonePattern = /^\d{10}$/;
    if (!phonePattern.test(phone)) {
        alert("Please enter a valid phone number.");
        return false;
    }

    if (address === '') {
        alert("Please enter the address.");
        return false;
    }

    return true;
}

function confirmSubmit(form) {
    const form = document.getElementById('add-driver-form');
    const formData = new FormData(form);

    fetch('../../../api/addDriver.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Driver added successfully.");
            form.reset();
        } else {
            alert('Failed to add the driver:');
        }
    })
    .catch((error) => {
        console.error('Error submitting driver:', error);
        alert('An error occurred while submitting the driver.');
    });
}