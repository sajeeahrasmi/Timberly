// Global variables to store current item and order IDs
let currentItemId = null;
let currentOrderId = null;

// Function to show modal for setting price
function showSetPriceModal(itemId, orderId) {
    currentItemId = itemId;
    currentOrderId = orderId;
    
    // Show the modal
    document.getElementById('setPriceModal').style.display = 'flex';
    
    // Focus on the input field
    document.getElementById('unitPrice').focus();
}

// Function to close the modal
function closeModal() {
    document.getElementById('setPriceModal').style.display = 'none';
}

// Function to handle unit price update
function updateUnitPrice() {
    const unitPrice = document.getElementById('unitPrice').value;
    
    // Validate input
    if (unitPrice === '' || isNaN(unitPrice) || parseFloat(unitPrice) < 0) {
        alert('Please enter a valid price');
        return;
    }
    
    // Send AJAX request to update unit price
    fetch('updateunitprice.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `itemId=${currentItemId}&orderId=${currentOrderId}&unitPrice=${unitPrice}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Price updated successfully');
            // Refresh the page to show updated price
            window.location.reload();
        } else {
            alert('Failed to update price: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating price:', error);
        alert('An error occurred while updating the price');
    });
    
    // Close the modal
    closeModal();
}

// Close modal if user clicks outside of it
window.onclick = function(event) {
    const modal = document.getElementById('setPriceModal');
    if (event.target === modal) {
        closeModal();
    }
};

// Add keyboard support for modal (Escape key to close)
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// Function to handle the existing button functionality
function goToOrders() {
    window.location.href = 'orders.php';
}

// Existing functions for your other buttons...
// (checkStock, approveOrder, rejectOrder)

// Function to show modal for setting price
function showSetPriceModal(itemId, orderId) {
    currentItemId = itemId;
    currentOrderId = orderId;
    
    // Show the modal
    document.getElementById('setPriceModal').style.display = 'flex';
    
    // Focus on the input field
    document.getElementById('unitPrice').focus();
}

// Function to close the modal
function closeModal() {
    document.getElementById('setPriceModal').style.display = 'none';
}

// Function to handle unit price update
function updateUnitPrice() {
    const unitPrice = document.getElementById('unitPrice').value;
    
    // Validate input
    if (unitPrice === '' || isNaN(unitPrice) || parseFloat(unitPrice) < 0) {
        alert('Please enter a valid price');
        return;
    }

    const type = document.getElementById('orderType').value;
    
    // Send AJAX request to update unit price
    fetch('updateunitprice.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `itemId=${currentItemId}&orderId=${currentOrderId}&unitPrice=${unitPrice}&type=${type}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Price updated successfully');
            // Refresh the page to show updated price
            window.location.reload();
        } else {
            alert('Failed to update price: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error updating price:', error);
        alert('An error occurred while updating the price');
    });
    
    // Close the modal
    closeModal();
}

// Close modal if user clicks outside of it
window.onclick = function(event) {
    const modal = document.getElementById('setPriceModal');
    if (event.target === modal) {
        closeModal();
    }
};

// Add keyboard support for modal (Escape key to close)
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

// Function to handle the existing button functionality
function goToOrders() {
    window.location.href = 'orders.php';
}

// Existing functions for your other buttons...
// (checkStock, approveOrder, rejectOrder)

function showSection(sectionId) {
    
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.style.display = 'none');

    
    document.getElementById(sectionId).style.display = 'block';
}


function goToOrders() {
    
    window.location.href = 'admin.php';
}


function checkStock(itemId) {
    // Make an AJAX call to check stock (for demonstration, using fetch API)
    fetch(`../../api/checkStock.php?itemId=${itemId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // All items in stock
            } else {
                alert(data.message); // Out of stock
                console.log(data.outOfStockItems); // Show which items are out of stock
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function approveOrder(itemId, orderId) {
    const orderType = document.getElementById('orderType').value;
    
    console.log('ItemID:', itemId, 'OrderID:', orderId, 'Type:', orderType);

    let apiEndpoint;

    switch (orderType) {
        case 'furniture':
            apiEndpoint = '../../api/approvefurnitureorder.php';
            break;
        case 'customized':
            apiEndpoint = '../../api/approvecustomizedorder.php';
            break;
        case 'lumber':
            apiEndpoint = '../../api/approvelumberorder.php';
            break;
        default:
            alert('Unknown order type.');
            return;
    }

    fetch(`${apiEndpoint}?itemId=${itemId}&orderId=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Order approved successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Something went wrong!');
            console.error('Error:', error);
        });
}

function rejectOrder(itemId, orderId) {
    const orderType = document.getElementById('orderType').value;

    let apiEndpoint;

    switch (orderType) {
        case 'furniture':
            apiEndpoint = '../../api/rejectfurnitureorder.php';
            break;
        case 'customized':
            apiEndpoint = '../../api/rejectcustomizedorder.php';
            break;
        case 'lumber':
            apiEndpoint = '../../api/rejectlumberorder.php';
            break;
        default:
            alert('Unknown order type.');
            return;
    }

    if (confirm('Are you sure you want to reject this order? This action cannot be undone.')) {
        fetch(`${apiEndpoint}?itemId=${itemId}&orderId=${orderId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Order rejected successfully!');
                    window.location.href = 'admin.php';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Something went wrong!');
                console.error('Error:', error);
            });
    }
}
