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
        <h1>Orders</h1>
        <br><br><br>
        <!-- Orders Table -->
        <div class="sub"><h3>All Orders</h3></div>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Order ID</th>
                    <th>Order Details</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include '../../api/getOrders.php'; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
