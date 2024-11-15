// Function to update the order status and progress bar
function updateStatus(status) {
    let progress = 0;
    let color = '';
    let hideElements = false;

    switch(status) {
        case 'Pending':
            progress = 0; 
            color = 'white'; 
            hideElements = false;
            break;
        case 'Confirm':
            progress = 25; 
            color = 'Yellow'; // yellow
            hideElements = false;
            break;    
        case 'Processing': 
            progress = 50; 
            color = '#e74c3c'; // Red
            hideElements = false;
            break;
        case 'Polishing': 
            progress = 75; 
            color = '#f39c12'; // Orange
            hideElements = true; // Hide elements when polishing
            break;
        case 'Delivering': 
            progress = 100; 
            color = '#2ecc71'; // Green
            hideElements = true; // Hide elements when delivering
            break;
    }

    // Update all product statuses
    document.querySelectorAll('.status').forEach(el => {
        el.innerText = status;
    });

    $('#progressBar').animate({ width: progress + '%' }, 500, function() {
        $(this).text(progress + '%');
    }).css('background-color', color);

    // Hide or show elements based on status
    const elementsToHide = document.querySelectorAll('.quantity, #deliveryFee');
    elementsToHide.forEach(el => {
        if (hideElements) {
            el.classList.add('hidden'); // Add hidden class when status is polishing or delivering
        } else {
            el.classList.remove('hidden'); // Remove hidden class for other statuses
        }
    });
    const quantityInputs = document.querySelectorAll('.quantity');
    quantityInputs.forEach(input => {
        if (hideElements) {
            input.setAttribute('disabled', 'true'); // Disable quantity field
        } else {
            input.removeAttribute('disabled'); // Enable quantity field
        }
    });
}

// Function to update the subtotal and total values
function updateTotal() {
    let subtotal = 0;

    // Get all rows in the table (excluding the header row)
    const rows = document.querySelectorAll('.order-details table tr:not(:first-child)');

    rows.forEach(row => {
        const priceText = row.cells[3].innerText.trim();
        const price = parseFloat(priceText.replace('Rs.', '').trim()) || 0;
        const quantityInput = row.querySelector('.quantity');
        const quantity = parseInt(quantityInput.value) || 1;
        subtotal += price * quantity;
    });

    // Get the delivery fee value
    const deliveryFee = parseFloat(document.getElementById('deliveryFee').value) || 0;

    // Calculate the total
    const total = subtotal + deliveryFee;

    // Update the subtotal and total in the DOM
    document.getElementById('subtotal').innerText = 'Rs.' + subtotal.toFixed(2);
    document.getElementById('total').innerText = 'Rs.' + total.toFixed(2);
}

// Ensure updateTotal is called on input change
document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('change', updateTotal);
});

// Ensure updateTotal is called on delivery fee change
document.getElementById('deliveryFee').addEventListener('change', updateTotal);

// Function to update Measurement Person Details
function updateDetails(type) {
    let isValid = true;
    let errorMessage = '';

    if (type === 'measurement') {
        const name = document.getElementById('name').value.trim();
        const arrivalDate = document.getElementById('arrivalDate').value;
        const arrivalTime = document.getElementById('arrivalTime').value;
        const phoneNumber = document.getElementById('phoneNumber').value.trim();

        // Validate name
        if (!name) {
            errorMessage += 'Name is required.\n';
            isValid = false;
        }

        // Validate arrival date
        if (!arrivalDate) {
            errorMessage += 'Arrival date is required.\n';
            isValid = false;
        }

        // Validate arrival time
        if (!arrivalTime) {
            errorMessage += 'Arrival time is required.\n';
            isValid = false;
        }

        // Validate phone number
        const phoneRegex = /^[0-9]{10}$/; // Simple regex for a 10-digit phone number
        if (!phoneRegex.test(phoneNumber)) {
            errorMessage += 'Invalid phone number. It should be 10 digits long.\n';
            isValid = false;
        }

        if (isValid) {
            // Update Measurement Person Details on the frontend
            document.querySelector('.card-container .card:first-child').innerHTML = ` 
                <h3>Measurement Person Details</h3>
                <p>Name: ${name}</p>
                <p>Arrival Date: ${arrivalDate}</p>
                <p>Arrival Time: ${arrivalTime}</p>
                <p>Phone: ${phoneNumber}</p>
                <button onclick="showPopup('measurementPopup')">Update</button>
            `;
            alert('Measurement details updated!');
            closePopup('measurementPopup');
        } else {
            alert('Please fix the following errors:\n' + errorMessage);
        }
    } 
}

// Function to show a popup
function showPopup(popupId) {
    document.getElementById(popupId).style.display = 'flex';
}

// Function to close a popup
function closePopup(popupId) {
    document.getElementById(popupId).style.display = 'none';
}

// Function to set the order title
function setOrderTitle(orderId) {
    document.getElementById('orderTitle').innerText = 'Track Order ID: ' + orderId;
}

// Example usage
$(document).ready(function() {
    const orderId = '12345'; // Replace with the actual order ID
    setOrderTitle(orderId);
    updateStatus('Pending'); // Set default status to 'Pending'
});
