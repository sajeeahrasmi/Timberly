<?php
require_once 'db.php';

$orderId = $_POST['orderId'] ?? '';
$name = $_POST['name'] ?? '';
$arrivalDate = $_POST['arrivalDate'] ?? '';
$arrivalTime = $_POST['arrivalTime'] ?? '';
$phone = $_POST['phone'] ?? '';

if ($orderId && $name && $arrivalDate && $arrivalTime && $phone) {
    $stmt = $conn->prepare("INSERT INTO measurement (orderId, name, date, time, contact) VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE name = VALUES(name), date = VALUES(date), time = VALUES(time), contact = VALUES(contact)");
    $stmt->bind_param("issss", $orderId, $name, $arrivalDate, $arrivalTime, $phone);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Database error: ' . $stmt->error;
    }

    $stmt->close();
} else {
    echo 'Missing required fields';
}

$conn->close();
?>
