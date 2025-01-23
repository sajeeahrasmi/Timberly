
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
            color = 'Yellow'; 
            hideElements = false;
            break;    
        case 'Processing': 
            progress = 50; 
            color = '#e74c3c';
            hideElements = false;
            break;
        case 'Polishing': 
            progress = 75; 
            color = '#f39c12'; 
            hideElements = true; 
            break;
        case 'Delivering': 
            progress = 100; 
            color = '#2ecc71'; 
            hideElements = true; 
            break;
    }

    
    document.querySelectorAll('.status').forEach(el => {
        el.innerText = status;
    });

    $('#progressBar').animate({ width: progress + '%' }, 500, function() {
        $(this).text(progress + '%');
    }).css('background-color', color);

    
    const elementsToHide = document.querySelectorAll('.quantity, #deliveryFee');
    elementsToHide.forEach(el => {
        if (hideElements) {
            el.classList.add('hidden'); 
        } else {
            el.classList.remove('hidden'); 
        }
    });
    const quantityInputs = document.querySelectorAll('.quantity');
    quantityInputs.forEach(input => {
        if (hideElements) {
            input.setAttribute('disabled', 'true'); 
        } else {
            input.removeAttribute('disabled'); 
        }
    });
}


function updateTotal() {
    let subtotal = 0;

   
    const rows = document.querySelectorAll('.order-details table tr:not(:first-child)');

    rows.forEach(row => {
        const priceText = row.cells[3].innerText.trim();
        const price = parseFloat(priceText.replace('Rs.', '').trim()) || 0;
        const quantityInput = row.querySelector('.quantity');
        const quantity = parseInt(quantityInput.value) || 1;
        if (quantity < 0) {
            alert("Quantity must be a positive number!");
            quantity = 1; 
            quantityInput.value = 1; 
        }
        
        subtotal += price * quantity;
    });

    
    const deliveryFeeInput = document.getElementById('deliveryFee');
    let deliveryFee = parseFloat(deliveryFeeInput.value) || 0;

    // Show a message if delivery fee is negative
    if (deliveryFee < 0) {
        alert("Delivery fee must be a positive number!");
        deliveryFee = 0; // Reset to a default value
        deliveryFeeInput.value = 0; // Update the input field
    }

    
    const total = subtotal + deliveryFee;

    
    document.getElementById('subtotal').innerText = 'Rs.' + subtotal.toFixed(2);
    document.getElementById('total').innerText = 'Rs.' + total.toFixed(2);
}


document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('change', updateTotal);
});


document.getElementById('deliveryFee').addEventListener('change', updateTotal);


function updateDetails(type) {
    let isValid = true;
    let errorMessage = '';

    if (type === 'measurement') {
        const name = document.getElementById('name').value.trim();
        const arrivalDate = document.getElementById('arrivalDate').value;
        const arrivalTime = document.getElementById('arrivalTime').value;
        const phoneNumber = document.getElementById('phoneNumber').value.trim();

        if (!name) {
            errorMessage += 'Name is required.\n';
            isValid = false;
        }

        
        if (!arrivalDate) {
            errorMessage += 'Arrival date is required.\n';
            isValid = false;
        }

        
        if (!arrivalTime) {
            errorMessage += 'Arrival time is required.\n';
            isValid = false;
        }

     
        const phoneRegex = /^[0-9]{10}$/; 
        if (!phoneRegex.test(phoneNumber)) {
            errorMessage += 'Invalid phone number. It should be 10 digits long.\n';
            isValid = false;
        }

        if (isValid) {
            
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


function showPopup(popupId) {
    document.getElementById(popupId).style.display = 'flex';
}


function closePopup(popupId) {
    document.getElementById(popupId).style.display = 'none';
}


function setOrderTitle(orderId) {
    document.getElementById('orderTitle').innerText = 'Track Order ID: ' + orderId;
}


$(document).ready(function() {
    const orderId = '12345'; 
    setOrderTitle(orderId);
    updateStatus('Pending'); 
});
