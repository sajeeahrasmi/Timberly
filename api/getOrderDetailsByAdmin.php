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

    // Query to fetch order items
    $orderItemsDataQuery = "
        SELECT
            'Furniture' AS category, 
            ofur.itemId,
            ofur.qty
        FROM orderfurniture ofur
        WHERE ofur.orderId = '$order_id'

        UNION ALL

        SELECT
            'Lumber' AS category, 
            olumber.itemId, 
            olumber.qty
        FROM orderlumber olumber
        WHERE olumber.orderId = '$order_id'

        UNION ALL

        SELECT
            'CustomisedFurniture' AS category, 
            ocf.itemId,
            ocf.qty
        FROM ordercustomizedfurniture ocf
        WHERE ocf.orderId = '$order_id'
        ";

    // Query to fetch transaction details
    $paymentDataQuery = "SELECT * FROM payment WHERE orderId = '$order_id'";

    $orderDetailsDataResult = mysqli_query($conn, $orderDetailsDataQuery);
    $orderItemsDataResult = mysqli_query($conn, $orderItemsDataQuery);
    $paymentDataResult = mysqli_query($conn, $paymentDataQuery);

    if (!$orderDetailsDataResult || !$orderItemsDataResult) {
        die("Error fetching order data: " . mysqli_error($conn));
    }

    $orderItems = [];
    while ($item = mysqli_fetch_assoc($orderItemsDataResult)) {
        $orderItems[] = $item;
    }

    $orderItemDetails = [];
    foreach ($orderItems as $item) {
        $itemId = $item['itemId'];
        $category = $item['category'];

        // Fetch item details based on category
        if ($category == 'Furniture') {
            $query = "SELECT * FROM furnitures WHERE furnitureId = '$itemId'";
        } elseif ($category == 'Lumber') {
            $query = "SELECT * FROM lumber WHERE lumberId = '$itemId'";
        } elseif ($category == 'CustomisedFurniture') {
            $query = "SELECT * FROM ordercustomizedfurniture WHERE itemId = '$itemId'";
        }

        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($details = mysqli_fetch_assoc($result)) {
                $orderItemDetails[] = array_merge($item, $details);
            }
        }
    }
    $orderItems = $orderItemDetails;

    $payments = [];
    while ($payment = mysqli_fetch_assoc($paymentDataResult)) {
        $payments[] = $payment;
    }
    // Format the date for each payment
    foreach ($payments as $index => $payment) {
        $datefromdb = $payment['date'];
        
        // Convert the datetime string to a Unix timestamp
        $timestamp = strtotime($datefromdb);
        
        if ($timestamp !== false) {
            // Format the date and time as "Month day, Year, hh:mm AM/PM"
            $formattedDate = date('F d, Y', $timestamp);
            $payments[$index]['date'] = $formattedDate;
        } else {
            // In case of invalid date format
            $payments[$index]['date'] = 'Invalid Date';
        }
    }
    $order = mysqli_fetch_assoc($orderDetailsDataResult);
    $datefromdb = $order['date'];
    $date = date('F d, Y', strtotime($datefromdb));
    $order['date'] = $date;
?>