<?php

include 'db.php';
// Include the database connection and authentication (assuming they're in the same directory)
// Correct variable to $itemId
$itemId = isset($_GET['itemId']) ? $_GET['itemId'] : null;

if (!$itemId) {
    echo json_encode(['success' => false, 'message' => 'Item ID is required.']);
    exit;
}

// Prepare the SQL query to check stock
$sql = "SELECT 
            ol.qty AS orderedQuantity,
            l.qty AS availableStock,
            l.lumberId, 
            l.type
        FROM orderlumber ol
        LEFT JOIN lumber l ON ol.itemId = l.lumberId
        WHERE ol.itemId = ? ";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $itemId); // Changed to use $itemId
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $outOfStockItems = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['orderedQuantity'] > $row['availableStock']) {
            $outOfStockItems[] = [
                'item' => $row['type'],
                'orderedQuantity' => $row['orderedQuantity'],
                'availableStock' => $row['availableStock']
            ];
        }
    }

    if (count($outOfStockItems) > 0) {
        echo json_encode([
            'success' => false,
            'message' => ' out of stock.',
            'outOfStockItems' => $outOfStockItems
        ]);
    } else {
        echo json_encode(['success' => true, 'message' => 'All items are in stock.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No items found for the given order.']);
}

$stmt->close();
$conn->close();

?>
