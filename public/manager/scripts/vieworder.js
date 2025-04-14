

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
    // Get the order type from the page
    const orderType = document.querySelector('[data-order-type]').getAttribute('data-order-type');
    
    // Log the values to ensure they're being passed correctly
    console.log('ItemID:', itemId, 'OrderID:', orderId, 'Type:', orderType);
    
    // Choose the appropriate API endpoint based on order type
    const apiEndpoint = orderType === 'furniture' 
        ? '../../api/approvefurnitureorder.php' 
        : '../../api/approvelumberorder.php';
    
    // Perform an AJAX request to approve the order with both IDs
    fetch(`${apiEndpoint}?itemId=${itemId}&orderId=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Order approved successfully!');
                location.reload();  // Reload the page to show the updated status
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
    // Get the order type from the page
    const orderType = document.querySelector('[data-order-type]').getAttribute('data-order-type');
    
    // Choose the appropriate API endpoint based on order type
    const apiEndpoint = orderType === 'furniture' 
        ? '../../api/rejectfurnitureorder.php' 
        : '../../api/rejectlumberorder.php';
    
    // Add confirmation before rejecting
    if (confirm('Are you sure you want to reject this order? This action cannot be undone.')) {
        fetch(`${apiEndpoint}?itemId=${itemId}&orderId=${orderId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Order rejected successfully!');
                    window.location.href = 'admin.php'; // Redirect to admin page
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