<?php
    include 'db.php';

    $order_id = $_GET['order_id'] ?? '';

    // Query to fetch order details
    $orderDetailsDataQuery = "
        SELECT
            o.orderId AS order_id,
            u.userId,
            u.name AS customerName,
            u.email,
            u.address,
            o.date,
            o.itemQty,
            o.totalAmount,
            o.status AS orderStatus,
            o.category
        FROM
            orders o
        JOIN
            user u ON o.userId = u.userId
        WHERE
            o.orderId = '$order_id'
        ";
    $orderDetailsDataResult = mysqli_query($conn, $orderDetailsDataQuery);

    if (!$orderDetailsDataResult) {
        die("Error fetching driver data: " . mysqli_error($conn));
    }

    $order = mysqli_fetch_assoc($orderDetailsDataResult);
    $datefromdb = $order['date'];
    $date = date('F d, Y', strtotime($datefromdb));
    $order['date'] = $date;
?>