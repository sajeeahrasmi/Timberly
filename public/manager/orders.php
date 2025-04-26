<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';


//$balance = $_SESSION['newTotalAmount'] ?? 0;
// Rest of your existing PHP code follows...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="./styles/orders.css">
    <style>
        .filter-section {
            margin: 20px 0;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        .filter-form {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .filter-form input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .filter-form button {
            padding: 8px 15px;
            background: #895D47;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .filter-form button:hover {
            background: #f5f5f5;
            color:#895D47;
            border : 2px solid #895D47;
        }
        .filter-form select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: white;
    color: #333;
    font-size: 14px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%23895D47' stroke-width='2'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 12px;
}

.filter-form select:focus {
    border-color: #895D47;
    outline: none;
    box-shadow: 0 0 5px rgba(137, 93, 71, 0.5);
}
.filter-form input,
.filter-form select {
    height: 40px;
    width : 170px;
}


    </style>
</head>
<body>
    <div class="order-content">
        <h1 class="page-title">Orders</h1>
        
        <div class="filter-section">
            <form id="filterForm" class="filter-form">
                <input 
                    type="text" 
                    name="customer_filter" 
                    id="customer_filter"
                    placeholder="Search by Customer ID"
                >
                <input 
                    type="text" 
                    name="order_filter" 
                    id="order_filter"
                    placeholder="Search by Order ID"
                >
                <select name="status_filter" id="status_filter">
            <option value="">By Order Status</option>
            <option value="Processing">Processing</option>
            
            <option value="Confirmed">Confirmed</option>
            <option value="Completed">Completed</option>
        </select>
        <!-- Item Status Filter -->
<select name="item_status_filter" id="item_status_filter">
    <option value="">By Item Status</option>
    <option value="Not_Approved">Not_Approved</option>
    <option value="Approved">Approved</option>
    <option value="Processing">Processing</option>
    <option value="Finished">Finished</option>
    <option value="Delivered">Delivered</option>
</select>
        <!-- Payment Status Filter -->
        <select name="payment_status_filter" id="payment_status_filter">
        <option value="">By Payment Status</option>
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
            <option value="Partially_Paid">Partially_Paid</option>
        </select>
                <button type="submit">Filter</button>
                <button type="button" id="clearFilters" class="button">Clear Filters</button>
            </form>
        </div>

        <div class="orders-section">
            <h3 class="section-title">All Orders</h3>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Customer Name</th>
                        <th>Order ID</th>
                        <th>Order Details</th>
                        <th>Total Amount</th>
                        <th>Amount To Pay</th>
                        <th>Payment Status</th>
                       <!-- <th>Order Status</th> -->
                        <th>Item Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <?php include '../../api/getOrders.php'; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            updateTable();
        });

        document.getElementById('clearFilters').addEventListener('click', function() {
            document.getElementById('customer_filter').value = '';
            document.getElementById('order_filter').value = '';
            document.getElementById('status_filter').value = '';
            document.getElementById('item_status_filter').value = '';
            document.getElementById('payment_status_filter').value = '';
            updateTable();
        });

        function updateTable() {
            const customerFilter = document.getElementById('customer_filter').value;
            const orderFilter = document.getElementById('order_filter').value;
            const statusFilter = document.getElementById('status_filter').value;
            const itemStatusFilter = document.getElementById('item_status_filter').value
            const paymentStatusFilter = document.getElementById('payment_status_filter').value;
            console.log(statusFilter);
            console.log(paymentStatusFilter);
            fetch(`../../api/getOrders.php?customer_filter=${encodeURIComponent(customerFilter)}&order_filter=${encodeURIComponent(orderFilter)}&status_filter=${encodeURIComponent(statusFilter)}&item_status_filter=${encodeURIComponent(itemStatusFilter)}&payment_status_filter=${encodeURIComponent(paymentStatusFilter)}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('ordersTableBody').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }
        // Add this script to your orders.php file before the closing </body> tag

// Add simple CSS styles 
// Add this script to your orders.php file before the closing </body> tag

// Add simple CSS styles 
const styles = document.createElement('style');
styles.innerHTML = `
    /* Highlight for delivered orders */
    tr.new-delivered {
        background-color: #ffe6d5 !important;
    }
    
    /* Simple badge */
    .new-badge {
        background-color: #895D47;
        color: white;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 12px;
        margin-left: 5px;
    }
    
    /* Sidebar link glow effect */
    .orders-glow {
        animation: sidebar-glow 1.5s infinite alternate;
    }
    
    @keyframes sidebar-glow {
        0% { box-shadow: 0 0 5px   #de5f4d; }
        100% { box-shadow: 0 0 15px  #de5f4d; }
    }
`;
document.head.appendChild(styles);

// Function to highlight delivered orders and update sidebar
function highlightDeliveredOrders() {
    // Get all table rows
    const tableRows = document.querySelectorAll('#ordersTableBody tr');
    let hasDeliveredOrders = false;
    
    tableRows.forEach(row => {
        // Get the status cell (8th column)
        const statusCell = row.cells[7];
        
        if (statusCell && statusCell.textContent.trim() === 'Delivered') {
            // Add highlighting class
            row.classList.add('new-delivered');
            hasDeliveredOrders = true;
            
            // Add a "NEW" badge to the status cell if it doesn't have one
            if (!statusCell.querySelector('.new-badge')) {
                const badge = document.createElement('span');
                badge.className = 'new-badge';
                badge.textContent = 'NEW';
                statusCell.appendChild(badge);
            }
        }
    });
    
    // Add glow effect to sidebar link if there are delivered orders
    if (hasDeliveredOrders) {
        // Target the specific sidebar link based on your HTML structure
        const sidebarLink = document.querySelector('li a[onclick="showSection(\'orders-section\')"]');
        if (sidebarLink) {
            sidebarLink.classList.add('orders-glow');
        }
    }
}

// Run once when the page loads
document.addEventListener('DOMContentLoaded', function() {
    highlightDeliveredOrders();
    
    // Re-run after filter updates
    const originalUpdateTable = window.updateTable;
    window.updateTable = function() {
        originalUpdateTable();
        // Wait for AJAX to complete
        setTimeout(highlightDeliveredOrders, 500);
    };
});
    </script>
</body>
</html>