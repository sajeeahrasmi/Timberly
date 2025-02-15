<?php

include_once '../../config/db_connection.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'addItem':
            addItem();
            break;

        case 'deleteItem':
            deleteItem();
            break;
      
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}

function addItem(){
    global $conn;

    $type = $_GET['type'];
    $furnitureId = $_GET['furnitureId'];
    $qty = $_GET['qty'];
    $size = $_GET['size'];
    $details = $_GET['details'];
    $orderId = $_GET['orderId'];

    if (empty($type) || empty($furnitureId) || empty($size) || empty($qty) || empty($orderId)) {
        echo json_encode(['error' => 'Invalid or missing input']);
        return;
    }

    mysqli_begin_transaction($conn);

    try {
        
        $query1 = "UPDATE orders SET itemQty = itemQty + 1 WHERE  orderId = $orderId;";
        $result1 = mysqli_query($conn, $query1);


        if (!$result1) {
            throw new Exception('Failed to update orders table');
        }

        $query2 = "
        INSERT INTO orderfurniture (orderId, itemId, type, qty, size, additionalDetails, status) 
        VALUES (?, ?, ?, ?, ?, ?, 'Pending')
        ";

        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("iisiss", $orderId, $furnitureId, $type, $qty, $size, $details);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to insert into orderfurniture table');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        // echo json_encode(['error' => "Already Added. Update quantity."]);
    }
    
}

function deleteItem(){
    global $conn;

    $orderId = $_GET['orderId'];
    $id = $_GET['id'];

    mysqli_begin_transaction($conn);

    try {
        
        $query1 = "UPDATE orders SET itemQty = itemQty - 1 WHERE  orderId = $orderId;";
        $result1 = mysqli_query($conn, $query1);

        if (!$result1) {
            throw new Exception('Failed to update orders table');
        }

        
        $query2 = "DELETE FROM orderfurniture WHERE id = $id";
        $result2 = mysqli_query($conn, $query2);

        if (!$result2) {
            throw new Exception('Failed to delete item.');
        }

        // Commit the transaction if all queries succeed
        mysqli_commit($conn);

        // Send success response
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        // Roll back the transaction if any query fails
        mysqli_rollback($conn);
        echo json_encode(['error' => "Couldn't delete item."]);
    }

}

?>