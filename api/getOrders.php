<?php
// Include the database connection (assuming it's in the same directory)
require_once 'db.php';

// Get the filter values from the query parameters
$customer_filter = isset($_GET['customer_filter']) ? $_GET['customer_filter'] : '';
$order_filter = isset($_GET['order_filter']) ? $_GET['order_filter'] : '';
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';
$payment_status_filter = isset($_GET['payment_status_filter']) ? $_GET['payment_status_filter'] : '';
$item_status_filter = isset($_GET['item_status_filter']) ? $_GET['item_status_filter'] : '';

// Base query for lumber orders
$sql_lumber = "SELECT 
    o.orderId AS main_order_id, 
    o.date, 
    o.itemQty,
    o.totalAmount, 
    o.status AS orderStatus, 
    o.paymentStatus,
    u.name AS customerName, 
    o.userId AS customerId,
   
    ol.orderId,  
    ol.itemId, 
    '' AS unitPrice,
    ol.qty,  
    ol.status AS itemStatus,
    CONCAT(l.type, ' (', ol.qty, ')') AS typeQty,
    '' AS description,
    'lumber' AS orderType
FROM orderlumber ol
LEFT JOIN orders o ON ol.orderId = o.orderId  
LEFT JOIN user u ON o.userId = u.userId
LEFT JOIN lumber l ON ol.itemId = l.lumberId

WHERE ol.status != 'Pending'";

// Base query for furniture orders - using 'orf' instead of 'of' as alias
$sql_furniture = "SELECT 
    o.orderId AS main_order_id, 
    o.date, 
    o.itemQty,
    o.totalAmount, 
    
    o.status AS orderStatus, 
    o.paymentStatus,
    u.name AS customerName, 
    o.userId AS customerId,
    
    orf.orderId,  
    orf.itemId, 
    orf.qty,
    orf.unitPrice,

    orf.status AS itemStatus,
    CONCAT(orf.type, ' - ', orf.size, ' (', orf.qty, ')') AS typeQty,
    orf.description,
    'furniture' AS orderType
FROM orderfurniture orf
LEFT JOIN orders o ON orf.orderId = o.orderId  
LEFT JOIN user u ON o.userId = u.userId

WHERE orf.status != 'Pending'";

$sql_customized = "SELECT 
    o.orderId AS main_order_id, 
    o.date, 
    o.itemQty,
    o.totalAmount, 
    
    o.status AS orderStatus, 
    o.paymentStatus,
    u.name AS customerName, 
    o.userId AS customerId,
   
    ocf.orderId,  
    ocf.itemId, 
    ocf.qty, 
    
    ocf.unitPrice, 
    ocf.status AS itemStatus,
    CONCAT(ocf.type, ' ', ocf.length, 'x', ocf.width, 'x', ocf.thickness, ' ' , ocf.category ,' (', ocf.qty, ')' ) AS typeQty,
    ocf.details AS description,
    'customized' AS orderType
FROM ordercustomizedfurniture ocf
LEFT JOIN orders o ON ocf.orderId = o.orderId  
LEFT JOIN user u ON o.userId = u.userId

WHERE ocf.status != 'Pending'";

// Add filters to the SQL queries if necessary
$whereClauses = [];
if ($customer_filter) {
    $whereClauses[] = "u.userId LIKE '%" . $conn->real_escape_string($customer_filter) . "%'";
}
if ($order_filter) {
    $whereClauses[] = "o.orderId LIKE '%" . $conn->real_escape_string($order_filter) . "%'";
}
if ($status_filter) {
    $whereClauses[] = "o.status = '" . $conn->real_escape_string($status_filter) . "'";
}
if ($payment_status_filter) {
    $whereClauses[] = "o.paymentStatus = '" . $conn->real_escape_string($payment_status_filter) . "'";
}

// Create the additional WHERE clauses (without the item status filter)
$additional_where = "";
if (count($whereClauses) > 0) {
    $additional_where = " AND " . implode(" AND ", $whereClauses);
}

// Apply item status filter separately to each query
if ($item_status_filter) {
    $item_status_condition = " AND ol.status = '" . $conn->real_escape_string($item_status_filter) . "'"; 
    $sql_lumber .= $additional_where . $item_status_condition;
    
    $item_status_condition = " AND orf.status = '" . $conn->real_escape_string($item_status_filter) . "'";
    $sql_furniture .= $additional_where . $item_status_condition;
    
    $item_status_condition = " AND ocf.status = '" . $conn->real_escape_string($item_status_filter) . "'";
    $sql_customized .= $additional_where . $item_status_condition;
} else {
    // Just add the other filters
    $sql_lumber .= $additional_where;
    $sql_furniture .= $additional_where;
    $sql_customized .= $additional_where;
}

// Combine the results with UNION
$sql = "($sql_lumber) UNION ($sql_furniture) UNION ($sql_customized) ORDER BY main_order_id";

// Execute the query
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output the data for each order
    while ($order = $result->fetch_assoc()) {
       
        $totalAmount = $order['totalAmount']; 
        
        
        $viewUrl = "vieworder.php?orderId={$order['orderId']}&itemId={$order['itemId']}&type={$order['orderType']}";
        
        
        $itemDisplay = $order['typeQty'];
        if ($order['orderType'] == 'furniture' && !empty($order['description'])) {
            $itemDisplay .= " - " . $order['description'];
        }

        $iStatus = $order['itemStatus'];
        if ($totalAmount == 0 && $order['itemStatus'] =='Delivered')
        {
            $iStatus = 'Completed';
        }
        else
        {
            $iStatus = $order['itemStatus'];
        }
        
        echo "<tr>
                <td>{$order['customerId']}</td>
                <td>{$order['customerName']}</td>
                <td>{$order['main_order_id']}</td>
                <td>{$itemDisplay}</td>
                <td>{$totalAmount}</td>
                <td>{$order['paymentStatus']}</td>
                <td>{$iStatus}</td>
                <td><a href='{$viewUrl}' class='view-btn'>View Order</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No records found</td></tr>";
}

$conn->close();
?>