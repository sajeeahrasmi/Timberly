<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="./styles/orders.css">
</head>
<body>
    <div class="content">
        <h1 class="page-title">Orders</h1>

        
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
                <tbody>
                    <?php 
                    include '../../api/getOrders.php';  

                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
