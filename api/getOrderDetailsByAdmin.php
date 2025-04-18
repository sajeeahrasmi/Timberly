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
    $transactionDataQuery = "
        SELECT
            transactionId,
            amount,
            date,
            description,
            paymentMethod
        FROM
            transactions
        WHERE
            orderId = '$order_id'
        ";

    $orderDetailsDataResult = mysqli_query($conn, $orderDetailsDataQuery);
    $orderItemsDataResult = mysqli_query($conn, $orderItemsDataQuery);
    $transactionDataResult = mysqli_query($conn, $transactionDataQuery);

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
            $query = "SELECT * FROM customizedfurniture WHERE itemId = '$itemId'";
        }

        $result = mysqli_query($conn, $query);
        if ($result) {
            while ($details = mysqli_fetch_assoc($result)) {
                $orderItemDetails[] = array_merge($item, $details);
            }
        }
    }
    $orderItems = $orderItemDetails;

    $transactions = [];
    while ($transaction = mysqli_fetch_assoc($transactionDataResult)) {
        $transactions[] = $transaction;
    }
    // Format the date for each transaction
    foreach ($transactions as $index => $transaction) {
        $datefromdb = $transaction['date'];
        
        // Convert the datetime string to a Unix timestamp
        $timestamp = strtotime($datefromdb);
        
        if ($timestamp !== false) {
            // Format the date and time as "Month day, Year, hh:mm AM/PM"
            $formattedDate = date('F d, Y, h:i A', $timestamp);
            $transactions[$index]['date'] = $formattedDate; // Assign formatted date to the 'date' field
        } else {
            // In case of invalid date format
            $transactions[$index]['date'] = 'Invalid Date';
        }
    }
    $order = mysqli_fetch_assoc($orderDetailsDataResult);
    $datefromdb = $order['date'];
    $date = date('F d, Y', strtotime($datefromdb));
    $order['date'] = $date;
?>