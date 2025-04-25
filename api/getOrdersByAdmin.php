<?php
include 'db.php';

// Pagination setup
$ordersPerPage = 8;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $ordersPerPage;

// Check for filter (e.g., minAmount)
$minAmount = isset($_GET['minAmount']) && is_numeric($_GET['minAmount']) ? floatval($_GET['minAmount']) : null;

// Adjust total count query based on filter
$totalOrdersQuery = "SELECT COUNT(*) as total FROM orders";
if (!is_null($minAmount)) {
    $totalOrdersQuery .= " WHERE totalAmount >= $minAmount";
}
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
$totalOrdersRow = mysqli_fetch_assoc($totalOrdersResult);
$totalOrders = $totalOrdersRow['total'];
$totalPages = ceil($totalOrders / $ordersPerPage);

// Adjust data fetch query based on filter
$orderDataQuery = "
    SELECT
        o.orderId AS order_id,
        u.name AS customerName,
        o.date,
        o.totalAmount,
        o.status AS orderStatus,
        o.category
    FROM
        orders o
    JOIN
        user u ON o.userId = u.userId
";

if (!is_null($minAmount)) {
    $orderDataQuery .= " WHERE o.totalAmount >= $minAmount";
}

$orderDataQuery .= " ORDER BY o.date ASC LIMIT $ordersPerPage OFFSET $offset";

$orderDataResult = mysqli_query($conn, $orderDataQuery);

if (!$orderDataResult) {
    die("Error fetching order data: " . mysqli_error($conn));
}

$orderData = [];

while ($row = mysqli_fetch_assoc($orderDataResult)) {
    $orderData[] = $row;
}
?>