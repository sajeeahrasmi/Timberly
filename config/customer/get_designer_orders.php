<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

include '../db_connection.php';

$userId = $_SESSION['userId']; // optional, in case you filter designer's own orders

// Get all saved chat sessions
$query = "
    SELECT DISTINCT dc.orderId, dc.itemId, ocf.category , ocf.type 
    FROM designerchat dc
    JOIN ordercustomizedfurniture ocf 
    ON dc.orderId = ocf.orderId AND dc.itemId = ocf.itemId
";
$result = $conn->query($query);

$ordersMap = [];

while ($row = $result->fetch_assoc()) {
    $oid = $row['orderId'];
    if (!isset($ordersMap[$oid])) {
        $ordersMap[$oid] = [
            'orderId' => $oid,
            'items' => [],
            'items' => []
        ];
    }
    $ordersMap[$oid]['items'][] = [
        'itemId' => $row['itemId'],
        'label' => $row['category'] . ' (' . $row['type'] . ')'
    ];
    
    

}

$response = array_values($ordersMap);
echo json_encode($response);

$conn->close();
?>
