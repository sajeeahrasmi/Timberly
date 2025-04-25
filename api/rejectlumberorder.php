<?php

require_once 'db.php';

if (isset($_GET['itemId']) && isset($_GET['orderId'])) {
    $itemId = intval($_GET['itemId']);
    $orderId = intval($_GET['orderId']);

    
    $qtyStmt = $conn->prepare("SELECT qty FROM orderlumber WHERE itemId = ? AND orderId = ?");
    $qtyStmt->bind_param("ii", $itemId, $orderId);
    $qtyStmt->execute();
    $result = $qtyStmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Order not found.']);
        $conn->close();
        exit;
    }

    $row = $result->fetch_assoc();
    $quantity = $row['qty'];
    $qtyStmt->close();

  
    $updateInventory = $conn->prepare("UPDATE lumber SET qty = qty + ? WHERE lumberId = ?");
    $updateInventory->bind_param("ii", $quantity, $itemId);
    $updateInventory->execute();
    $updateInventory->close();

   
    $unitPriceStmt = $conn->prepare("SELECT unitPrice FROM lumber WHERE lumberId = ?");
    $unitPriceStmt->bind_param("i", $itemId);
    $unitPriceStmt->execute();
    $unitPriceResult = $unitPriceStmt->get_result();
    $unitPriceRow = $unitPriceResult->fetch_assoc();
    $unitPriceStmt->close();

    if (!$unitPriceRow) {
        echo json_encode(['status' => 'error', 'message' => 'Lumber not found.']);
        $conn->close();
        exit;
    }

    $unitPrice = $unitPriceRow['unitPrice'];
    $itemTotal = $quantity * $unitPrice;

    
    $updateOrder = $conn->prepare("UPDATE orders SET totalAmount = GREATEST(totalAmount - ?, 0) WHERE orderId = ?");
    $updateOrder->bind_param("di", $itemTotal, $orderId);
    $updateOrder->execute();
    $updateOrder->close();

    
    $updateOrderStatus = $conn->prepare("UPDATE orderlumber SET status = 'Not_Approved' WHERE itemId = ? AND orderId = ?");
    $updateOrderStatus->bind_param("ii", $itemId, $orderId);
    $updateOrderStatus->execute();
    $affectedRows = $updateOrderStatus->affected_rows;
    $updateOrderStatus->close();

    
        echo json_encode(['status' => 'success', 'message' => 'Order updated successfully.']);
    

} else {
    echo json_encode(['status' => 'error', 'message' => 'Item ID or Order ID not provided.']);
}

$conn->close();
