<?php
require_once 'db.php';

if (isset($_POST['driverId'])) {
    $driverId = $_POST['driverId'];

    $orderId = $_POST['orderId'] ?? 0; // Fallback to 0 if orderId is not available
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

        $updateOrder = $conn->prepare("UPDATE orderlumber SET driverId = ? WHERE orderId = ?");
        $updateOrder->bind_param("ii", $driverId, $orderId);
        $updateOrder->execute();
        echo json_encode(['status' => 'success', 'message' => 'Driver assigned successfully']);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Driver ID not provided']);
}
?>
