<?php

include_once '../../config/db_connection.php';
header('Content-Type: application/json');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'updateSelectToOrder':
            updateSelectToOrder();
            break;

        case 'updateQuantity':
            updateQuantity();
            break;
        
        case 'removeItem':
            removeItem();
            break;
    
        case 'clearCart':
            clearCart();
            break;

        case 'placeOrder':
            placeOrder();
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}


function removeItem(){
    global $conn;

    $cartId = $_GET['cartId'];

    mysqli_begin_transaction($conn);

    try {
        
        $query = "DELETE FROM cart  WHERE  cartId = ?;";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("i", $cartId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to delete ');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        
    }

}

function updateSelectToOrder(){
    global $conn;

    $cartId = $_GET['cartId'];
    $selectToOrder = $_GET['selectToOrder'];

    mysqli_begin_transaction($conn);

    try {
        
        $query = "UPDATE cart SET selectToOrder = ? WHERE  cartId = ?;";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("si", $selectToOrder, $cartId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to update ');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        
    }
}

function updateQuantity(){
    global $conn;

    $cartId = $_GET['cartId'];
    $qty = $_GET['qty'];

    mysqli_begin_transaction($conn);

    try {
        
        $query = "UPDATE cart SET qty = ? WHERE  cartId = ?;";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("ii", $qty, $cartId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to update ');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        
    }
}

function clearCart(){
    global $conn;

    $userId = $_GET['userId'];

    mysqli_begin_transaction($conn);

    try {
        
        $query = "DELETE FROM cart  WHERE  userId = ?;";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("i", $userId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to delete ');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        
    }

}

function placeOrder() {
    global $conn;

    $userId = $_GET['userId'];
    $itemQty = $_GET['itemQty'];
    $totalAmount = $_GET['totalAmount'];

    mysqli_begin_transaction($conn);

    try {
        $query = "SELECT c.*, f.*
                  FROM cart c 
                  JOIN furnitures f ON c.productId = f.furnitureId 
                  WHERE c.userId = ? AND c.selectToOrder = 'yes' ";;
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'No items selected.']);
            return;
        }

        $orderQuery = "INSERT INTO orders (userId, itemQty, totalAmount, status, date, category) VALUES (?, ?, ?, 'Pending', NOW(), 'Furniture')";
        $orderStmt = $conn->prepare($orderQuery);
        $orderStmt->bind_param("iid", $userId, $itemQty, $totalAmount);
        $orderStmt->execute();
        $orderId = $orderStmt->insert_id;

        $insertFurnitureQuery = "INSERT INTO orderfurniture (orderId, itemId, type, qty, size, additionalDetails, unitPrice, status) 
                                 VALUES (?, ?, ?, ?, ?, ?,?, 'Pending')";
        $insertStmt = $conn->prepare($insertFurnitureQuery);

        while ($row = $result->fetch_assoc()) {
            $insertStmt->bind_param(
                "iisiisd",
                $orderId,
                $row['productId'],
                $row['type'],
                $row['qty'],
                $row['size'],
                $row['additionalDetails'],
                $row['unitPrice']
            );
            $insertStmt->execute();
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true, 'orderId' => $orderId]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => 'Error placing order: ' . $e->getMessage()]);
    }
}

?>