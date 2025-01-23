<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: ../../public/login.html");
    exit;
}

// Output the customer's data as JSON
header('Content-Type: application/json');
echo json_encode([
    'name' => htmlspecialchars($_SESSION['name']),
    'role' => htmlspecialchars($_SESSION['role']),
    'userId' => $_SESSION['userId']
]);
?>

