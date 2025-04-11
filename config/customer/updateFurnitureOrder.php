<?php

include_once '../../config/db_connection.php';
header('Content-Type: application/json');

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'addItem':
            addItem();
            break;

        case 'deleteItem':
            deleteItem();
            break;
        
        case 'updateItem':
            updateItem();
            break;
    
        case 'updateReview':
            updateReview();
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

function updateItem(){
    global $conn;

    $id = $_GET['Id'];
    $type = $_GET['type'];
    $size = $_GET['size'];
    $qty = $_GET['qty'];
    $details = $_GET['details'];

    mysqli_begin_transaction($conn);

    try {
        
        $query = "UPDATE orderfurniture SET type = ?, size = ?, qty = ?, additionalDetails = ? WHERE  id = ?;";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("ssisi", $type, $size, $qty, $details, $id);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to update into orderfurniture table');
        }

        mysqli_commit($conn);

        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);

        echo json_encode(['error' => $e->getMessage()]);
        
    }
}

function updateReview() {
    global $conn;

    $orderId = $_GET['orderId'];
    $Id = $_GET['Id'];
    $text = $_GET['reviewText'];

    if (!$orderId || !$Id || !$text) {
        echo json_encode(["success" => false, "message" => "Invalid parameters"]);
        return;
    }

    mysqli_begin_transaction($conn);

    try {
        $query = "INSERT INTO review (review) VALUES (?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $text);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            throw new Exception("Failed to insert review");
        }

        $query1 = "SELECT reviewId FROM review WHERE review = ?";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $text);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $reviewData = mysqli_fetch_assoc($result1);
        $reviewId = $reviewData['reviewId'];

        if (!$reviewId) {
            throw new Exception("Failed to retrieve review ID");
        }

        $query2 = "UPDATE orderfurniture SET reviewId = ? WHERE id = ?";
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, "ii", $reviewId, $Id);
        $result2 = mysqli_stmt_execute($stmt2);

        if (!$result2) {
            throw new Exception("Failed to update orderLumber with review ID");
        }

        mysqli_commit($conn);
        echo json_encode(["success" => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }

    mysqli_close($conn);
}
?>