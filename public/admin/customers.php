<?php
    include '../..api/auth.php';
    include '../../api/getCustomers.php';
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly Ltd</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/customers.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
    <div class="dashboard-container">
        <div style="position: fixed">
            <?php include "./components/sidebar.php" ?>
        </div>
        <div class="main-content" style="margin-left: 300px">
            <?php include "./components/header.php" ?>
            <div class="customers-display-box">
                <div style="display: flex;
                            justify-content: space-between;
                            align-items: center;"
                        class="content-header">
                    <h2>Customers</h2>
                    <a href="./addCustomer.php"><i class="fa-solid fa-circle-plus" style="margin-right: 8px"></i>Add Customer</a>
                </div>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Registered on</th>
                            <th>Telephone no</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($customerData as $item): ?>
                        <tr onclick="window.location.href='./customerDetails.php?customer_id=<?php echo urlencode($item['customer_id']); ?>'">
                            <td><?php echo $item['customer_id']; ?></td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['registered_on']; ?></td>
                            <td><?php echo $item['tele_num']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>