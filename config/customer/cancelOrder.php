<?php
header('Content-Type: application/json');

try {
    // Database connection
    $conn = new PDO("mysql:host=localhost;dbname=timberly", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the orderId from the query parameter
    $orderId = $_GET['orderId'] ?? null;

    if (!$orderId) {
        echo json_encode(['success' => false, 'message' => 'Order ID is required.']);
        exit;
    }

    // Begin a transaction
    $conn->beginTransaction();

    $updateOrderLumberStmt = $conn->prepare("DELETE FROM orderLumber WHERE orderId = :orderId");
    $updateOrderLumberStmt->execute([':orderId' => $orderId]);

    // Update the orders table
    $updateOrdersStmt = $conn->prepare("DELETE FROM orders WHERE orderId = :orderId");
    $updateOrdersStmt->execute([':orderId' => $orderId]);

    // Update the orderLumber table
    

    // Commit the transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Order cancelled successfully.']);
} catch (Exception $e) {
    // Rollback the transaction on error
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
