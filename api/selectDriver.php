<?php
require_once 'db.php';

if (isset($_POST['driverId'])) {
    $driverId = $_POST['driverId'];


    $orderId = $_POST['orderId'] ?? 0;
    $itemId = $_POST['itemId'] ?? '';
    $type = $_POST['type'] ?? ''; 
    $date = $_POST['date'] ?? null;

    if (!$date || !strtotime($date)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or missing date']);
        exit;
    }
    

    // Double check availability before assigning
    $stmt = $conn->prepare("SELECT available FROM driver WHERE driverId = ?");
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    $result = $stmt->get_result();
    $driver = $result->fetch_assoc();

    if (!$driver || $driver['available'] !== 'YES') {
        echo json_encode(['status' => 'error', 'message' => 'Driver not available']);
    } else {
        // Update driver availability
        $update = $conn->prepare("UPDATE driver SET available = 'NO' WHERE driverId = ?");
        $update->bind_param("i", $driverId);
        $update->execute();
      
        // Determine the appropriate table based on type
        if ($type === 'lumber') {
            $updateOrder = $conn->prepare("UPDATE orderlumber SET driverId = ?  , date = ? WHERE orderId = ? AND itemId = ?");
        } elseif ($type === 'furniture') {
            $updateOrder = $conn->prepare("UPDATE orderfurniture SET driverId = ?  , date = ? WHERE orderId = ? AND itemId = ?");
        } elseif ($type === 'customized') {
            $updateOrder = $conn->prepare("UPDATE ordercustomizedfurniture SET driverId = ? , date = ?  WHERE orderId = ? AND itemId = ?");
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid order type']);
            $stmt->close();
            $conn->close();
            exit;
        }

        $updateOrder->bind_param("isii", $driverId,$date, $orderId, $itemId );
        $updateOrder->execute();

        echo json_encode(['status' => 'success', 'message' => 'Driver assigned successfully']);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Driver ID not provided']);
}
?>
