<?php
    include '../..api/auth.php';
    include '../../api/getSuppliers.php';
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
        <link rel="stylesheet" href="./styles/suppliers.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div class="suppliers-display-box">
                    <div style="display: flex;
                                justify-content: space-between;
                                align-items: center;"
                         class="content-header">
                        <h2>Suppliers</h2>
                        <a href="./addSupplier.php"><i class="fa-solid fa-circle-plus" style="margin-right: 8px"></i>Add Supplier</a>
                    </div>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Supplier ID</th>
                                <th>Name</th>
                                <th>Registered on</th>
                                <th>Telephone no</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($supplierData as $item): ?>
                                <tr onclick="window.location.href='supplierDetails.php?supplier_id=<?php echo urlencode($item['supplier_id']); ?>'">
                                    <td><?php echo $item['supplier_id']; ?></td>
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
        </div>
    </body>
</html>