<?php

include_once '../../config/db_connection.php'; // Include your database connection file
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Use supplier name from session or fallback to default
// $supplierName = isset($_SESSION['supplier_name']) ? $_SESSION['supplier_name'] : 'Supplier';
// 
// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

// Fetch user name directly (not using prepared statement)
$sql = "SELECT name FROM user WHERE userId = $userId";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $userName = $row['name'];
} else {
    $userName = "Supplier";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly - Supplier</title>

    <link rel="stylesheet" href="/Supplier/styles/components/header.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../scripts/components/header.js" defer></script>
</head>
<body>
    <header class="top-bar">
        <h1>Welcome,  <?php echo $_SESSION['name']; ?>!</h1>
        <div class="user-profile">
           <span><i class="fa-regular fa-bell" onclick="window.location.href=`http://localhost/Timberly/public/supplier/notification.php`" style="transition: 0.3s;"></i></span>
            <a href="./userProfile.php">
                <span style="display: flex;">
                    <i class="fa-regular fa-user"></i>
                    <h5><?php echo $_SESSION['name']; ?></h5>
                </span>
            </a>
        </div>

        
    </header>
</body>
</html>
