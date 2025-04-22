<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../../public/login.php"); 
    exit;
}

header('Content-Type: application/json');
echo json_encode([
    'name' => htmlspecialchars($_SESSION['name']),
    'userId' => $_SESSION['userId']
]);
?>

