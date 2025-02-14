<?php

include_once '../../config/db_connection.php';


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'cancelFurniture':
            cancelFurniture();
            break;
        
        case 'cancelLumber':
            cancelLumber();
            break;
        
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}


function cancelFurniture() {
    global $conn;

    if (!isset($_GET['orderId'])) {
        echo json_encode(['success' => false, 'error' => 'Order ID missing']);
        exit;
    }

    $orderId = $_GET['orderId'];
    error_log("Received orderId: " . $orderId); // Log for debugging

    mysqli_begin_transaction($conn);

    try {
        $query1 = "DELETE FROM orderfurniture WHERE orderId = ?";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param("i", $orderId);
        $stmt1->execute();

        if ($stmt1->affected_rows === 0) {
            throw new Exception('Failed to cancel the order in orderfurniture');
        }

        $query2 = "DELETE FROM orders WHERE orderId = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $orderId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to cancel the order in orders');
        }

        mysqli_commit($conn);
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("Error cancelling order: " . $e->getMessage()); // Log error
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }





}
function cancelLumber() {
    global $conn;

    if (!isset($_GET['orderId'])) {
        echo json_encode(['success' => false, 'error' => 'Order ID missing']);
        exit;
    }

    $orderId = $_GET['orderId'];
    error_log("Received orderId: " . $orderId); // Log for debugging

    mysqli_begin_transaction($conn);

    try {
        $query1 = "DELETE FROM orderLumber WHERE orderId = ?";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param("i", $orderId);
        $stmt1->execute();

        if ($stmt1->affected_rows === 0) {
            throw new Exception('Failed to cancel the order in orderfurniture');
        }

        $query2 = "DELETE FROM orders WHERE orderId = ?";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bind_param("i", $orderId);
        $stmt2->execute();

        if ($stmt2->affected_rows === 0) {
            throw new Exception('Failed to cancel the order in orders');
        }

        mysqli_commit($conn);
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("Error cancelling order: " . $e->getMessage()); // Log error
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }





}

?>
