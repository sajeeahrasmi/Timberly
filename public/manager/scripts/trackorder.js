
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
    
    // Select all rows in the order details table except header
    const rows = document.querySelectorAll('.order-details table tr:not(:first-child)');
    
    rows.forEach(row => {
        // Get the price from the price column (4th cell)
        const priceText = row.cells[4].innerText.trim();
        const qtyText = row.cells[2].querySelector('input').value.trim(); // Get the value from the quantity input
        
        // Parse the price (removing currency symbol and commas)
        const price = parseFloat(priceText.replace('Rs.', '').replace(',', '').trim()) || 0;
        const qty = parseInt(qtyText.replace(',', '').trim()) || 0;  // Parse quantity correctly
        
        // Add to subtotal
        subtotal += price * qty;  // Multiply price by quantity for correct subtotal
        
        // For debugging
        console.log(`Row price: ${price}, Quantity: ${qty}, Running subtotal: ${subtotal}`);
    });
    
    // Get delivery fee from the input in order summary
    const deliveryFeeInput = document.querySelector('.order-summary input[type="number"]');
    let deliveryFee = parseFloat(deliveryFeeInput.value) || 0;
    
    if (deliveryFee < 0) {
        alert("Delivery fee must be a positive number!");
        deliveryFee = 0;
        deliveryFeeInput.value = 0;
    }
    
    // Final total is subtotal + delivery fee
    const total = subtotal + deliveryFee;
    
    // For debugging
    console.log(`Final calculation - Subtotal: ${subtotal}, Delivery Fee: ${deliveryFee}, Total: ${total}`);
    
    // Update the total display - make sure the value is actually displayed
    document.getElementById('total').innerText = total.toFixed(2);
}

// Function to update price when quantity changes
function updatePriceOnQuantityChange(input) {
    // Get the row containing this quantity input
    const row = input.closest('tr');
    
    // Get the price from the first cell (3rd index, as the price is in the 4th column)
    const unitPriceText = row.cells[4].innerText.trim();
    const unitPrice = parseFloat(unitPriceText.replace('Rs.', '').replace(',', '').trim()) || 0;
    
    // Get the new quantity value
    const quantity = parseInt(input.value) || 1;
    
    if (quantity < 0) {
        alert("Quantity must be a positive number!");
        input.value = 1;
        return;
    }
    
    // Calculate new total price for this item
    const newTotalPrice = unitPrice * quantity; // Correct formula
    
    // Update the price cell (4th cell)
    row.cells[3].innerText = 'Rs.' + newTotalPrice.toFixed(2);
    
    // For debugging
    console.log(`Quantity changed to ${quantity}, New price: ${newTotalPrice}`);
    
    // Update the overall total
    updateTotal();
}


// Add event listeners when the document loads
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all quantity inputs
    document.querySelectorAll('.order-details table input[type="number"]').forEach(input => {
        input.addEventListener('change', function() {
            updatePriceOnQuantityChange(this);
        });
    });
    
    // Add event listener to delivery fee input
    document.querySelector('.order-summary input[type="number"]').addEventListener('change', updateTotal);
    
    // Calculate initial total based on current prices
    updateTotal();
    
    // For debugging - log the structure of the table
    console.log("Table structure:", document.querySelector('.order-details table'));
});
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
function goToOrders() {
    
    window.location.href = 'admin.php';
}
