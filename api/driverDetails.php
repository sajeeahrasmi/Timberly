<?php
// File: api/getDriverDetails.php
header('Content-Type: application/json');
require_once 'db.php';

// Check for driver ID
if (empty($_GET['driverId'])) {
    echo json_encode(['status' => 'error', 'message' => 'Driver ID required']);
    exit;
}

$driverId = intval($_GET['driverId']);

// Get driver details with a join to the user table
$sql = "SELECT d.driverId, d.vehicleNo, u.name, u.phone 
        FROM driver d 
        LEFT JOIN user u ON d.driverId = u.userId 
        WHERE d.driverId = ?";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $driverId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $driver = $result->fetch_assoc();
        
        echo json_encode([
            'status' => 'success',
            'driver' => [
                'driverId' => $driver['driverId'],
                'name' => $driver['name'] ?? "Driver #$driverId",
                'phone' => $driver['phone'] ?? 'N/A',
                'vehicleNo' => $driver['vehicleNo'] ?? 'N/A'
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Driver not found']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>