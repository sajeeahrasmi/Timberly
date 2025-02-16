

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
    // Log the values to ensure they're being passed correctly
    console.log('ItemID:', itemId, 'OrderID:', orderId);
    
    // Perform an AJAX request to approve the order with both IDs
    fetch(`../../api/approvelumberorder.php?itemId=${itemId}&orderId=${orderId}`)
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
    // Add confirmation before rejecting
    if (confirm('Are you sure you want to reject this order? This action cannot be undone.')) {
        fetch(`../../api/rejectlumberorder.php?itemId=${itemId}&orderId=${orderId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Order rejected successfully!');
                    window.location.href = 'admin.php'; // Reload the page to reflect changes
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