<?php
header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=localhost;dbname=Timberly", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get POST data
    $data = json_decode(file_get_contents("php://input"), true);

    $orderId = $data['orderId'] ?? null;
    $itemId = $data['itemId'] ?? null;
    $newQty = $data['newQty'] ?? null;

    if (!$orderId || !$itemId || !$newQty) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit;
    }

    // Update the orderLumber table
    $stmt = $conn->prepare("
        UPDATE orderLumber 
        SET qty = :newQty 
        WHERE orderId = :orderId AND itemId = :itemId
    ");
    $stmt->execute([
        ':newQty' => $newQty,
        ':orderId' => $orderId,
        ':itemId' => $itemId
    ]);

    // Check if rows were affected
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Quantity updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update quantity.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
