<?php

require_once 'db.php';


if (isset($_GET['itemId']) && isset($_GET['orderId'])) {
    $itemId = $_GET['itemId'];
    $orderId = $_GET['orderId'];
    
    
    $conn->begin_transaction();

    try {
        
        $fetchOrderQuery = "SELECT ol.*, l.qty as available_quantity 
                           FROM orderlumber ol
                           JOIN lumber l ON ol.itemId = l.lumberId 
                           WHERE ol.itemId = ? AND ol.orderId = ?";
        $stmt = $conn->prepare($fetchOrderQuery);
        $stmt->bind_param("ii", $itemId, $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('Order not found.');
        }
        
        $orderDetails = $result->fetch_assoc();
        
        
        if ($orderDetails['available_quantity'] < $orderDetails['qty']) {
            throw new Exception('Not enough stock available.');
        }
        
        
        $updateOrderQuery = "UPDATE orderlumber SET status = 'Approved' 
                           WHERE itemId = ? AND orderId = ?";
        $stmt = $conn->prepare($updateOrderQuery);
        $stmt->bind_param("ii", $itemId, $orderId);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            throw new Exception('Order status update failed.');
        }
        
        
        $updateLumberQuery = "UPDATE lumber 
                             SET qty = qty - ? 
                             WHERE lumberId = ?";
        $stmt = $conn->prepare($updateLumberQuery);
        $stmt->bind_param("ii", $orderDetails['qty'], $itemId);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            throw new Exception('Lumber quantity update failed.');
        }
        
       
        $conn->commit();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Order approved and inventory updated successfully.'
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