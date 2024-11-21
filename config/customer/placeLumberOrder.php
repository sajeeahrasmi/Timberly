<?php
header('Content-Type: application/json');

try {
    $conn = new PDO("mysql:host=localhost;dbname=Timberly", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read JSON input
    $input = json_decode(file_get_contents("php://input"), true);

    // Extract order and items data
    $order = $input['order'];
    $items = $input['items'];

    // Begin transaction
    $conn->beginTransaction();

    // Insert into orders table
    $stmt = $conn->prepare("
        INSERT INTO orders (userId, itemQty, date, totalAmount, status, category) 
        VALUES (:userId, :itemQty, NOW(), :totalAmount, 'Pending', 'Lumber')
    ");
    $stmt->execute([
        ':userId' => $order['userId'],
        ':itemQty' => $order['itemQty'],
        ':totalAmount' => $order['totalAmount']
    ]);

    // Get the last inserted orderId
    $orderId = $conn->lastInsertId();

    // Insert each item into orderLumber table
    $stmt = $conn->prepare("
        INSERT INTO orderlumber (orderId, itemId, qty, status) 
        VALUES (:orderId, :itemId, :qty, 1)
    ");

    foreach ($items as $item) {
        $stmt->execute([
            ':orderId' => $orderId,
            ':itemId' => $item['lumberId'],
            ':qty' => $item['qty']
        ]);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback transaction if an error occurs
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
