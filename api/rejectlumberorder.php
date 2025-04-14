<?php
// Include database connection
require_once 'db.php';

if (isset($_GET['itemId']) && isset($_GET['orderId'])) {
    $itemId = $_GET['itemId'];
    $orderId = $_GET['orderId'];
    
    $conn->begin_transaction();

    try {
        // ✅ Get the quantity before deleting the order
        $qtyStmt = $conn->prepare("SELECT qty FROM orderlumber WHERE itemId = ? AND orderId = ?");
        $qtyStmt->bind_param("ii", $itemId, $orderId);
        $qtyStmt->execute();
        $result = $qtyStmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception('Order not found.');
        }

        $row = $result->fetch_assoc();
        $quantity = $row['qty'];
        $qtyStmt->close();

        // ✅ Add the quantity back to inventory
        $updateInventory = $conn->prepare("UPDATE lumber SET qty = qty + ? WHERE lumberId = ?");
        $updateInventory->bind_param("ii", $quantity, $itemId);
        $updateInventory->execute();
        $updateInventory->close();

        // Delete the order record
        $deleteQuery = "DELETE FROM orderlumber 
                       WHERE itemId = ? AND orderId = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("ii", $itemId, $orderId);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            throw new Exception('Order not found or already deleted.');
        }
        
        $conn->commit();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Order deleted successfully.'
        ]);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Item ID or Order ID not provided.'
    ]);
}

$conn->close();
?>
