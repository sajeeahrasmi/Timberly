<?php

session_start();

$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;
$amount = isset($_GET['amount']) ? intval($_GET['amount']) : 1000;

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$queryCat = "SELECT * FROM orders WHERE orderId = ?";
$stmtCat = $conn->prepare($queryCat);
$stmtCat->bind_param("i", $orderId);
$stmtCat->execute();
$resultCat = $stmtCat->get_result();
$orderData = $resultCat->fetch_assoc();

$category = $orderData['category'] ?? 'Unknown';
$status = $orderData['status'] ?? 'Unknown';
$totalAmount = $orderData['totalAmount'] ?? 0;
$itemQty = $orderData['itemQty'] ?? 0;

$minAmount = 1000000;
$chargeAmount = max($amount * 100, $minAmount);

require __DIR__ . "/vendor/autoload.php";

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/Timberly/public/customer/success.php?orderId=$orderId&amount=$amount",
    "cancel_url" => "http://localhost/Timberly/public/customer/orderHistory.php",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "lkr",
                "unit_amount" => $chargeAmount,
                "product_data" => [
                    "name" => "Timberly Order Payment"
                ]
            ]
        ]
    ]
]);

http_response_code(303);
header("Location: " . $checkout_session->url);