<?php
// Include the database connection (assuming it's in the same directory)
require_once 'db.php';

// Get the filter values from the query parameters
$customer_filter = isset($_GET['customer_filter']) ? $_GET['customer_filter'] : '';
$order_filter = isset($_GET['order_filter']) ? $_GET['order_filter'] : '';

// Prepare the SQL query to fetch orders based on filters
$sql = "SELECT 
    o.orderId, 
    o.date, 
    o.itemQty,
    o.totalAmount, 
    o.status AS orderStatus, 
    u.name AS customerName, 
    o.userId AS customerId,
    ol.orderId,  
    ol.itemId, 
    ol.qty,  
    ol.status AS itemStatus,
    CONCAT(l.type, ' (', ol.qty, ')') AS typeQty  -- Fetch the 'type' from the lumber table
FROM orderlumber ol
LEFT JOIN orders o ON ol.orderId = o.orderId  
LEFT JOIN user u ON o.userId = u.userId
LEFT JOIN lumber l ON ol.itemId = l.lumberId
WHERE ol.status != 'Pending'"; 

// Add filters to the SQL query if necessary
$whereClauses = [];
if ($customer_filter) {
    $whereClauses[] = "u.userId LIKE '%" . $conn->real_escape_string($customer_filter) . "%'";
}
if ($order_filter) {
    $whereClauses[] = "o.orderId LIKE '%" . $conn->real_escape_string($order_filter) . "%'";
}

// Only append additional WHERE conditions if necessary
if (count($whereClauses) > 0) {
    $sql .= " AND " . implode(" AND ", $whereClauses);
}

// Execute the query
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output the data for each order
    while ($order = $result->fetch_assoc()) {
        // Calculate total amount (totalAmount = qty * unitPrice)
        $totalAmount = $order['totalAmount']; 
        
        // Set balance to 0 temporarily
        $balance = 0;

        // Output the order details
        echo "<tr>
                <td>{$order['customerId']}</td>
                <td>{$order['customerName']}</td>
                <td>{$order['orderId']}</td>
                <td>{$order['typeQty']}</td>  <!-- Display the concatenated value -->
                <td>{$totalAmount}</td>
                <td>{$totalAmount}</td>  <!-- Adjusted: totalAmount instead of balance calculation -->
                <td>{$balance}</td>  <!-- Balance set to 0 -->
                <td>{$order['itemStatus']}</td>
                <td><a href='vieworder.php?orderId=" . $order['orderId'] . "&itemId=" . $order['itemId'] . "' class='view-btn'>View Order</a></td>

              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No records found</td></tr>";
}

// Close the connection
$conn->close();
?>
