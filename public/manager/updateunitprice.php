<?php

require_once '../../api/auth.php';
require_once '../../api/db.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = isset($_POST['itemId']) ? intval($_POST['itemId']) : 0;
    $orderId = isset($_POST['orderId']) ? intval($_POST['orderId']) : 0;
    $unitPrice = isset($_POST['unitPrice']) ? floatval($_POST['unitPrice']) : 0;
    $type = isset($_POST['type']) ? $_POST['type'] : 'furniture'; 

    
    $table = '';
    if ($type === 'furniture') {
        $table = 'orderfurniture';
    } elseif ($type === 'customized') {
        $table = 'ordercustomizedfurniture';
    } else {
        echo json_encode(['success' => false, 'message' => 'Unsupported order type']);
        exit;
    }

    $conn->begin_transaction();

    try {
        
        $stmt = $conn->prepare("UPDATE $table SET unitPrice = ? WHERE orderId = ? AND itemId = ?");
        $stmt->bind_param("dii", $unitPrice, $orderId, $itemId);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
          
            $stmtQty = $conn->prepare("SELECT qty FROM $table WHERE orderId = ? AND itemId = ?");
            $stmtQty->bind_param("ii", $orderId, $itemId);
            $stmtQty->execute();
            $resultQty = $stmtQty->get_result();
            $qty = $resultQty->fetch_assoc()['qty'] ?? 1;
            $stmtQty->close();
            
            $stmtFee = $conn->prepare("SELECT deliveryFee FROM orders WHERE orderId = ?");
            $stmtFee->bind_param("i", $orderId);
            $stmtFee->execute();
            $resultFee = $stmtFee->get_result();
            $deliveryFee = $resultFee->fetch_assoc()['deliveryFee'] ?? 0;
            $stmtFee->close();

            
            $itemTotal = $unitPrice * $qty;

            
            $stmtItems = $conn->prepare("SELECT unitPrice, qty FROM $table WHERE orderId = ?");
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

           
            $totalAmount += $deliveryFee * $itemCount;

          
            $stmtUpdateTotal = $conn->prepare("UPDATE orders SET totalAmount = ? WHERE orderId = ?");
            $stmtUpdateTotal->bind_param("di", $totalAmount, $orderId);
            $stmtUpdateTotal->execute();
            $stmtUpdateTotal->close();
        }

       
        $conn->commit();

        echo json_encode([
            'success' => $success,
            'totalAmount' => $totalAmount ?? 0
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

