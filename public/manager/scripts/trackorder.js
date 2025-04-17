console.log(document.getElementById("orderId").value)
console.log(document.getElementById("itemId").value)
console.log(document.getElementById("orderType").value)
function updateStatus(status, oId, iId) {
    let progress = 0;
    let color = '';
    let hideElements = false;

    switch(status) {
        case 'Pending':
            progress = 0; 
            color = 'white'; 
            hideElements = false;
            break;
        case 'Confirmed':
            progress = 17; 
            color = 'Yellow'; 
            hideElements = false;
            break;    
        case 'Processing': 
            progress = 34; 
            color = '#e74c3c';
            hideElements = false;
            break;
        case 'Not_Delivered': 
            progress = 51; 
            color = '#f39c12'; 
            hideElements = true; 
            break;
        case 'Delivered': 
            progress = 76; 
            color = 'purple'; 
            hideElements = true; 
            break;
        case 'Completed': 
            progress = 100; 
            color = '#2ecc71'; 
            hideElements = true; 
            break;
    }
    const orderType = document.getElementById("orderType").value;
    fetch('../../api/updateStatus.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `orderId=${oId}&itemId=${iId}&status=${status}&orderType=${orderType}`
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the backend
        console.log(data); // Display the response for debugging
        
        // Update the status text in the table
        document.querySelectorAll('.order-details table tr').forEach(row => {
            // Find the status cell (2nd column in each row)
            const statusCell = row.cells && row.cells[1];
            if (statusCell) {
                statusCell.innerText = status;
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });

    // Update progress bar immediately for better UX
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
    //console.log(deliveryFeeInput.value); // Debugging line to check the value of delivery fee input
    let deliveryFee = parseFloat(deliveryFeeInput.value) || 0;
    console.log(deliveryFee); 
    
    if (deliveryFee < 0) {
        alert("Delivery fee must be a positive number!");
        deliveryFee = 0;
        deliveryFeeInput.value = 0.00;
    }
    
    // Final total is subtotal + delivery fee
    const total = subtotal + deliveryFee;
    
    // For debugging
    console.log(`Final calculation - Subtotal: ${subtotal}, Delivery Fee: ${deliveryFee}, Total: ${total}`);
    
    // Update the total display - make sure the value is actually displayed
    document.getElementById('total').innerText = total.toFixed(2);
    //code for send orderid for update the total in the database
    const orderId =  document.getElementById("orderId").value;
    const itemId =  document.getElementById("itemId").value;
    const orderType = document.getElementById("orderType").value;
    if (orderType == 'lumber') {
    //const quantity =  document.getElementById("quantity").value;
    fetch('../../api/updateOrderTotal.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `orderId=${orderId}&itemId=${itemId}&dfree=${deliveryFee}`
    })
    .then(async response => {
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            console.log('Response from updateOrderTotal:', data);
        } catch (e) {
            console.error('Failed to parse JSON. Raw response:', text);
        }
    })
    .catch(error => console.error('Fetch error:', error));
    
    
}
else if (orderType == 'furniture') {
    fetch('../../api/updateOrderTotalFurniture.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `orderId=${orderId}&itemId=${itemId}&dfree=${deliveryFee}`
    })
    .then(async response => {
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            console.log('Response from updateOrderTotalFurniture:', data);
        } catch (e) {
            console.error('Failed to parse JSON. Raw response:', text);
        }
    })
    .catch(error => console.error('Fetch error:', error));
}
else if (orderType == 'customized') {
    fetch('../../api/updateOrderTotalCustomizedFurniture.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `orderId=${orderId}&itemId=${itemId}&dfree=${deliveryFee}`
    })
    .then(async response => {
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            console.log('Response from updateOrderTotalCustomizedFurniture:', data);
        } catch (e) {
            console.error('Failed to parse JSON. Raw response:', text);
        }
    })
    .catch(error => console.error('Fetch error:', error));
}
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
    //save the new quantity to the database
    const itemId =  document.getElementById("itemId").value;
    const orderId =  document.getElementById("orderId").value;
    const orderType = document.getElementById("orderType").value;
    //console.log(orderType)
    if(orderType == 'lumber')
    {
    fetch('../../api/updateqty.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `itemId=${itemId}&orderId=${orderId}&quantity=${quantity}&ordertype=${orderType}`
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => {
        alert("Not Enough Stock"); // Show the exact DB-trigger message to the user
         // Recalculate price
    });
    updateTotal();
}
else if(orderType == 'furniture')
{

    fetch('../../api/updateqtyFurniture.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `itemId=${itemId}&orderId=${orderId}&quantity=${quantity}&ordertype=${orderType}`
    })
    .then(async response => {
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            console.log(data);
        } catch (e) {
            console.error('Invalid JSON:', text); // This will show raw response from server
             // Show actual DB response message (if any)
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong!');
    });

    // Update the overall total
    updateTotal();
}
else if (orderType == 'customized') {
    fetch('../../api/updateqtyCustomizedFurniture.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `itemId=${itemId}&orderId=${orderId}&quantity=${quantity}&ordertype=${orderType}`
    })
    .then(async response => {
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            console.log(data);
        } catch (e) {
            console.error('Invalid JSON:', text); // This will show raw response from server
             // Show actual DB response message (if any)
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Something went wrong!');
    });
    updateTotal();

}
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
        const orderId = document.getElementById('orderId').value;

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
            // Send data to PHP via AJAX
            fetch('../../api/updateMeasurementPerson.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `orderId=${encodeURIComponent(orderId)}&name=${encodeURIComponent(name)}&arrivalDate=${encodeURIComponent(arrivalDate)}&arrivalTime=${encodeURIComponent(arrivalTime)}&phone=${encodeURIComponent(phoneNumber)}`
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    alert('Measurement details saved!');
                    closePopup('measurementPopup');
                    document.querySelector('.card-container .card:first-child').innerHTML = ` 
                        <h3>Measurement Person Details</h3>
                        <p>Name: ${name}</p>
                        <p>Arrival Date: ${arrivalDate}</p>
                        <p>Arrival Time: ${arrivalTime}</p>
                        <p>Phone: ${phoneNumber}</p>
                        <button onclick="showPopup('measurementPopup')">Update</button>
                    `;
                } else {
                    alert('Failed to save measurement details: ' + data);
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
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
    // Get the actual order ID from the hidden input field
    const orderId = document.getElementById('orderId').value;
    // Only set the title if it's not already set correctly
    if (!document.getElementById('orderTitle').innerText.includes(orderId)) {
        setOrderTitle(orderId);
    }
    
    // Initialize progress bar based on current status
    initializeProgressBar();
});
function goToOrders() {
    
    window.location.href = 'admin.php';
}
function initializeProgressBar() {
    // Get the current status from the first row of the order details table
    const statusCell = document.querySelector('.order-details table tr:not(:first-child) td:nth-child(2)');
    
    if (statusCell) {
        const currentStatus = statusCell.innerText.trim();
        
        // Set progress bar without making an API call
        let progress = 0;
        let color = 'white';
        
        switch(currentStatus) {
            case 'Pending':
                progress = 0; 
                color = 'white'; 
                break;
            case 'Confirmed':
                progress = 17; 
                color = 'Yellow'; 
                break;    
            case 'Processing': 
                progress = 34; 
                color = '#e74c3c';
                break;
            case 'Not_Delivered': 
                progress = 51; 
                color = '#f39c12'; 
                break;
            case 'Delivered': 
                progress = 76; 
                color = 'purple'; 
                break;
            case 'Completed': 
                progress = 100; 
                color = '#2ecc71'; 
                break;
        }
        
        // Update the progress bar
        $('#progressBar').css({
            'width': progress + '%',
            'background-color': color
        }).text(progress + '%');
        
        // Handle visibility of elements based on status
        const hideElements = ['Not_Delivered', 'Delivered', 'Completed'].includes(currentStatus);
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
}

// Add this script at the bottom of your page or in a separate JS file
document.addEventListener('DOMContentLoaded', function() {
    // Get all unit price input elements
    const unitPriceInputs = document.querySelectorAll('.unitPrice-input');
    
    // Add event listeners to each input
    unitPriceInputs.forEach(input => {
        input.addEventListener('change', updateUnitPrice);
    });
    
    // Function to update unit price in database
    function updateUnitPrice(event) {
        const input = event.target;
        const itemId = input.getAttribute('data-item-id');
        const newUnitPrice = input.value;
        const orderId = document.getElementById('orderId').value; // Get order ID from the hidden input
        
        // Validate input
        if (newUnitPrice === '' || isNaN(newUnitPrice)) {
            alert('Please enter a valid price');
            return;
        }
        
        // Send AJAX request to update unit price
        fetch('updateunitprice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `itemId=${itemId}&unitPrice=${newUnitPrice}&orderId=${orderId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the total price cell if needed
                const row = input.closest('tr');
                const qtyInput = row.querySelector('#qty');
                const qty = qtyInput ? qtyInput.value : 1;
                const totalPriceCell = row.querySelector('td:nth-child(4)');
                
                if (totalPriceCell) {
                    const totalPrice = parseFloat(newUnitPrice) * parseInt(qty);
                    totalPriceCell.textContent = 'Rs.' + totalPrice.toFixed(2);
                }
                
                // Optional: Show success message
                console.log('Price updated successfully');
            } else {
                // Show error message
                alert('Failed to update price: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error updating price:', error);
            alert('An error occurred while updating the price');
        });
    }
});

