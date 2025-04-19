<?php

include_once '../../config/db_connection.php';


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'addItem':
            addItem();
            break;

        case 'getStatus':
            getStatus();
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


function addItem() {
    global $conn;

    $type = $_GET['type'];
    $length = $_GET['length'];
    $width = $_GET['width'];
    $thickness = $_GET['thickness'];
    $qty = $_GET['qty'];
    $orderId = $_GET['orderId'];
    $userId = $_GET['userId'];
    $lumberId = $_GET['lumberId'];

    if (empty($type) || empty($length) || empty($width) || empty($thickness) || empty($qty)) {
        echo json_encode(['error' => 'Invalid or missing input']);
        return;
    }

    mysqli_begin_transaction($conn);

    try {
        $query1 = "UPDATE orders SET itemQty = itemQty + 1 WHERE userId = $userId AND orderId = $orderId;";
        $result1 = mysqli_query($conn, $query1);

        if (!$result1) {
            throw new Exception('Failed to update orders table');
        }

        $query2 = "INSERT INTO orderlumber (orderId, itemId, qty, status) VALUES ($orderId, $lumberId, $qty, 1)";
        $result2 = mysqli_query($conn, $query2);

        if (!$result2) {
            throw new Exception('Failed to insert into orderlumber table');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => "Already Added. Update quantity."]);
    }
}

function getStatus(){
    global $conn;
    $orderId = $_GET['orderId'];
    $userId = $_GET['userId'];

    if(empty($orderId) && empty($userId)){
        echo json_encode(['error' => 'Order ID or user ID is required.']);
        return;
    }

    $query = "SELECT status FROM orders WHERE orderId = $orderId AND userId = $userId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode(['success' => true, 'status' => $row['status']]);
        } else {
            echo json_encode(['error' => 'Order not found']);
        }
    } else {
        echo json_encode(['error' => 'Failed to fetch order status']);
    }
}

function deleteItem(){
    global $conn;

    $orderId = $_GET['orderId'];
    $userId = $_GET['userId'];
    $itemId = $_GET['itemId'];

    mysqli_begin_transaction($conn);

    try {
        
        $query1 = "UPDATE orders SET itemQty = itemQty - 1 WHERE userId = $userId AND orderId = $orderId;";
        $result1 = mysqli_query($conn, $query1);

        if (!$result1) {
            throw new Exception('Failed to update orders table');
        }

        // Insert into the second table (e.g., 'orderlumber')
        $query2 = "DELETE FROM orderLumber WHERE orderId = $orderId AND itemId = $itemId";
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
