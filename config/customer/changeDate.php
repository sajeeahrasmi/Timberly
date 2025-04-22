<?php

include_once '../../config/db_connection.php';


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'updateMeasurementDate':
            updateMeasurementDate();
            break;
        
        case 'updateDoorDriverDate' :
            updateDoorDriverDate();
            break;
        
        case 'updateFurnitureDriverDate':
            updateFurnitureDriverDate();
            break;
        
        case 'updateLumberDriverDate':
            updateLumberDriverDate();
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}


function updateMeasurementDate() {
    global $conn;

    $orderId = $_GET['orderId'] ?? null;
    $newDate = $_GET['newDate'] ?? null;

    if (!$orderId || !$newDate) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        return;
    }

    $checkQuery = "SELECT dateChanged FROM measurement WHERE orderId = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['dateChanged'] === 'yes') {
        echo json_encode(['success' => false, 'message' => 'Date has already been changed once.']);
        return;
    }

    $updateQuery = "UPDATE measurement SET date = ?, dateChanged = 'yes' WHERE orderId = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("si", $newDate, $orderId);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
    }
}

function updateDoorDriverDate() {
    global $conn;

    $orderId = $_GET['orderId'] ?? null;
    $newDate = $_GET['newDate'] ?? null;
    $oldDate = $_GET['oldDate'] ?? null;

    if (!$orderId || !$newDate) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        return;
    }

    $checkQuery = "SELECT dateChanged FROM ordercustomizedfurniture  WHERE orderId = ? AND date = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("is", $orderId, $oldDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['dateChanged'] === 'yes') {
        echo json_encode(['success' => false, 'message' => 'Date has already been changed once.']);
        return;
    }

    $updateQuery = "UPDATE ordercustomizedfurniture SET date = ?, dateChanged = 'yes' WHERE orderId = ? AND date = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("sis", $newDate, $orderId, $oldDate);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
    }
}

function updateFurnitureDriverDate() {
    global $conn;

    $orderId = $_GET['orderId'] ?? null;
    $newDate = $_GET['newDate'] ?? null;
    $oldDate = $_GET['oldDate'] ?? null;

    if (!$orderId || !$newDate) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        return;
    }

    $checkQuery = "SELECT dateChanged FROM orderfurniture  WHERE orderId = ? AND date = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("is", $orderId, $oldDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['dateChanged'] === 'yes') {
        echo json_encode(['success' => false, 'message' => 'Date has already been changed once.']);
        return;
    }

    $updateQuery = "UPDATE orderfurniture SET date = ?, dateChanged = 'yes' WHERE orderId = ? AND date = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("sis", $newDate, $orderId, $oldDate);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
    }
}

function updateLumberDriverDate() {
    global $conn;

    $orderId = $_GET['orderId'] ?? null;
    $newDate = $_GET['newDate'] ?? null;
    $oldDate = $_GET['oldDate'] ?? null;

    if (!$orderId || !$newDate) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        return;
    }

    $checkQuery = "SELECT dateChanged FROM orderlumber  WHERE orderId = ? AND date = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("is", $orderId, $oldDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['dateChanged'] === 'yes') {
        echo json_encode(['success' => false, 'message' => 'Date has already been changed once.']);
        return;
    }

    $updateQuery = "UPDATE orderlumber SET date = ?, dateChanged = 'yes' WHERE orderId = ? AND date = ?";
    $stmtUpdate = $conn->prepare($updateQuery);
    $stmtUpdate->bind_param("sis", $newDate, $orderId, $oldDate);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed.']);
    }
}

?>
