<?php

include_once '../../config/db_connection.php'; // Include your database connection file
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Use supplier name from session or fallback to default
$supplierName = isset($_SESSION['supplier_name']) ? $_SESSION['supplier_name'] : 'Supplier';
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
        <h1>Welcome, <?php echo htmlspecialchars($supplierName); ?>!</h1>
        <div class="user-profile">
            <span><i class="fa-regular fa-bell" style="transition: 0.3s;"></i></span>
            <a href="./userProfile.php">
                <span style="display: flex;">
                    <i class="fa-regular fa-user"></i>
                    <h5><?php echo htmlspecialchars($supplierName); ?></h5>
                </span>
            </a>
        </div>
    </header>
</body>
</html>
