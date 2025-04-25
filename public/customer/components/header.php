<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];


include '../../../config/db_connection.php';

$query = "SELECT name FROM user WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$name = $row['name'] ?? '';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>

    <link rel="stylesheet" href="http://localhost/Timberly/public/customer/styles/header.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../scripts/header.js" defer></script>
</head>
<body>
    <header class="top-bar">
        <h1>Welcome <?php echo $name ?> !</h1>
        <div class="user-profile">
            <span><i class="fa-solid fa-cart-shopping" onclick="window.location.href=`http://localhost/Timberly/public/customer/orderCart.php`"></i></span>
            <span><i class="fa-regular fa-bell" onclick="window.location.href=`http://localhost/Timberly/public/customer/notification.php`"></i></span>
            <span style="display: flex;" onclick="window.location.href=`http://localhost/Timberly/public/customer/customerProfile.html`"><i class="fa-regular fa-user" ></i><h5>Profile</h5></span>
        </div>
    </header>
    
</body>
</html>