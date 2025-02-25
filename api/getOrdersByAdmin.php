<?php
    include 'db.php';

    // Query to fetch order details
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
    $orderDataResult = mysqli_query($conn, $orderDataQuery);

    if (!$orderDataResult) {
        die("Error fetching driver data: " . mysqli_error($conn));
    }

    // Fetch all rows into an array
    $orderData = [];

    while ($row = mysqli_fetch_assoc($orderDataResult)) {
        $orderData[] = $row;
    }
?>