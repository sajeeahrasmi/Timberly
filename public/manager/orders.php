<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';

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
                        <th>Total Payment</th>
                        <th>Balance</th>
                        <th>Status</th>
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
            updateTable();
        });

        function updateTable() {
            const customerFilter = document.getElementById('customer_filter').value;
            const orderFilter = document.getElementById('order_filter').value;

            fetch(`../../api/getOrders.php?customer_filter=${encodeURIComponent(customerFilter)}&order_filter=${encodeURIComponent(orderFilter)}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('ordersTableBody').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>