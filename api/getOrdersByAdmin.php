<?php
include 'db.php';

// Pagination setup
$ordersPerPage = 8;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $ordersPerPage;

// Get total number of orders
$totalOrdersQuery = "SELECT COUNT(*) as total FROM orders";
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
$totalOrdersRow = mysqli_fetch_assoc($totalOrdersResult);
$totalOrders = $totalOrdersRow['total'];
$totalPages = ceil($totalOrders / $ordersPerPage);

// Updated query with LIMIT and OFFSET
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
    ORDER BY o.date ASC
    LIMIT $ordersPerPage OFFSET $offset
";

$orderDataResult = mysqli_query($conn, $orderDataQuery);

if (!$orderDataResult) {
    die("Error fetching order data: " . mysqli_error($conn));
}

$orderData = [];

while ($row = mysqli_fetch_assoc($orderDataResult)) {
    $orderData[] = $row;
}
?>