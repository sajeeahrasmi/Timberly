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
        INSERT INTO orders (userId, itemQty, date, status, category) 
        VALUES (:userId, :itemQty, NOW(),  'Pending', 'Furniture')
    ");
    $stmt->execute([
        ':userId' => $order['userId'],
        ':itemQty' => $order['itemQty']
    ]);

    // Get the last inserted orderId
    $orderId = $conn->lastInsertId();

    // Insert each item into orderFurniture table
    $stmt = $conn->prepare("
        INSERT INTO orderfurniture (orderId, itemId, qty, size, additionalDetails, type, status) 
        VALUES (:orderId, :productId, :qty, :size, :additionalDetails, :type, 'Pending')
    ");

    foreach ($items as $item) {
        try {
            $stmt->execute([
                ':orderId' => $orderId,
                ':productId' => $item['productId'],
                ':qty' => $item['qty'],
                ':type' => $item['type'],
                ':size' => $item['size'],
                ':additionalDetails' => $item['details']
            ]);
            
        } catch (PDOException $e) {
            error_log("Error inserting item: " . $e->getMessage());
            throw $e;
        }
    }

    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
