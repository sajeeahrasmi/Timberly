<?php
header('Content-Type: application/json');

try {
    // Establish database connection
    $conn = new PDO("mysql:host=localhost;dbname=timberly", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the user ID from the query parameter
    $id = $_GET['userId'] ?? null;

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'User ID is required.']);
        exit;
    }

    // Get the latest order ID for the specific user
    $latestOrderStmt = $conn->prepare("SELECT MAX(orderId) AS latestOrderId FROM orders WHERE userId = 1");
    // $latestOrderStmt->bindValue(':userId', $id, PDO::PARAM_INT);
    $latestOrderStmt->execute();
    $latestOrder = $latestOrderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$latestOrder || !$latestOrder['latestOrderId']) {
        echo json_encode(['success' => false, 'message' => 'No orders found for this user.']);
        exit;
    }

    $latestOrderId = $latestOrder['latestOrderId'];

    // Fetch the order details for the latest order ID
    $detailsStmt = $conn->prepare("
        SELECT ol.orderId, ol.itemId, ol.qty, l.type, l.length, l.width, l.thickness, l.unitPrice
        FROM orderLumber ol
        JOIN lumber l ON ol.itemId = l.lumberId
        WHERE ol.orderId = :orderId
    ");
    $detailsStmt->execute([':orderId' => $latestOrderId]);
    $items = $detailsStmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'items' => $items]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
