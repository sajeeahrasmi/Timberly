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
?>