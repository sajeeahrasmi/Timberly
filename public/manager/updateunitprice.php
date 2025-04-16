<?php
// Authentication check MUST be the first thing in the file
require_once '../../api/auth.php';
require_once '../../api/db.php'; // Adjust path based on your file structure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = isset($_POST['itemId']) ? intval($_POST['itemId']) : 0;
    $orderId = isset($_POST['orderId']) ? intval($_POST['orderId']) : 0;
    $unitPrice = isset($_POST['unitPrice']) ? floatval($_POST['unitPrice']) : 0;
    
    // Start transaction to ensure data consistency
    $conn->begin_transaction();
    
    try {
        // Update unit price in orderfurniture table
        $stmt = $conn->prepare("UPDATE orderfurniture SET unitPrice = ? WHERE orderId = ? AND itemId = ?");
        $stmt->bind_param("dii", $unitPrice, $orderId, $itemId);
        $success = $stmt->execute();
        $stmt->close();
        
        if ($success) {
            // Get current quantity
            $stmtQty = $conn->prepare("SELECT qty FROM orderfurniture WHERE orderId = ? AND itemId = ?");
            $stmtQty->bind_param("ii", $orderId, $itemId);
            $stmtQty->execute();
            $resultQty = $stmtQty->get_result();
            $qty = $resultQty->fetch_assoc()['qty'] ?? 1;
            $stmtQty->close();
            
            // Get delivery fee
            $stmtFee = $conn->prepare("SELECT deliveryFee FROM orders WHERE orderId = ?");
            $stmtFee->bind_param("i", $orderId);
            $stmtFee->execute();
            $resultFee = $stmtFee->get_result();
            $deliveryFee = $resultFee->fetch_assoc()['deliveryFee'] ?? 0;
            $stmtFee->close();
            
            // Calculate new total for this item
            $itemTotal = $unitPrice * $qty;
            
            // Update total in orders table
            // First get all items for this order
            $stmtItems = $conn->prepare("SELECT unitPrice, qty FROM orderfurniture WHERE orderId = ?");
            $stmtItems->bind_param("i", $orderId);
            $stmtItems->execute();
            $resultItems = $stmtItems->get_result();
            
            $totalAmount = 0;
            $itemCount = 0;
            
            while ($row = $resultItems->fetch_assoc()) {
                if ($row['unitPrice'] !== null) {
                    $totalAmount += $row['unitPrice'] * $row['qty'];
                    $itemCount++;
                }
            }
            $stmtItems->close();
            
            // Apply delivery fee
            $totalAmount += $deliveryFee * $itemCount;
            
            // Update total in orders table
            $stmtUpdateTotal = $conn->prepare("UPDATE orders SET totalAmount = ? WHERE orderId = ?");
            $stmtUpdateTotal->bind_param("di", $totalAmount, $orderId);
            $stmtUpdateTotal->execute();
            $stmtUpdateTotal->close();
        }
        
        // Commit transaction
        $conn->commit();
        
        echo json_encode([
            'success' => $success,
            'totalAmount' => $totalAmount ?? 0
        ]);
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>