<?php
// Database connection placeholder
// include('db_connection.php');

// Initialize variables
$message = '';

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $driver_id = $_POST['driver_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $nic = $_POST['nic'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $tele_num = $_POST['tele_num'] ?? '';
    $reg_day = $_POST['reg_day'] ?? ''; //registered date
    $last_delv_day = $_POST['last_delv_day'] ?? '';
    $tot_dels = $_POST['tot_dels'] ?? ''; //total deliveries
    $deliveries = $_POST['deliveries'] ?? '';

    if (isset($_POST['save'])) {
        // Update product logic
        // $query = "UPDATE products SET name='$name', category='$category', description='$description', price='$price', stock='$stock', visibility='$visibility' WHERE id='$prod_id'";
        // mysqli_query($db_connection, $query);

        $message = 'Product updated successfully!';
    } elseif (isset($_POST['delete'])) {
        // Delete product logic
        // $query = "DELETE FROM products WHERE id='$prod_id'";
        // mysqli_query($db_connection, $query);

        $message = 'Product deleted successfully!';
    }
}

// Handle GET requests for initial data
$driver_id = $_GET['driver_id'] ?? 'Unknown';
$name = $_GET['name'] ?? 'Unknown';
$nic = $_GET['nic'] ?? 'Unknown';
$email = $_GET['email'] ?? 'Unknown';
$address = $_GET['address'] ?? 'Unknown';
$tele_num = $_GET['tele_num'] ?? 'Unknown';
$reg_day = $_GET['reg_day'] ?? 'Unknown';
$last_delv_day = $GET['last_delv_day'] ?? 'Unknown';
$tot_dels = $_GET['tot_dels'] ?? 'Unknown';
$deliveries = $_GET['deliveries'] ?? 'Unknown';
?>

<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./styles/driverDetails.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="main-content">
                <?php include "./components/header.php" ?>
                <div>
                    
                </div>
            </div>
        </div>
    </body>
</html>