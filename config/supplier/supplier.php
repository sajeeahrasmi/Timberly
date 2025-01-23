<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'supplier') {
    header("Location: ../../public/login.html"); // Redirect to login if not logged in
    exit;
}

// Output the customer's data as JSON
header('Content-Type: application/json');
echo json_encode([
    'name' => htmlspecialchars($_SESSION['name']),
    'userId' => $_SESSION['userId']
]);
?>

