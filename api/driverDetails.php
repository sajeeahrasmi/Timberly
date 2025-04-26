<?php

header('Content-Type: application/json');
require_once 'db.php';


if (empty($_GET['driverId'])) {
    echo json_encode(['status' => 'error', 'message' => 'Driver ID required']);
    exit;
}

$driverId = intval($_GET['driverId']);
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;
$itemId = isset($_GET['itemId']) ? intval($_GET['itemId']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';


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
        
        
        $date = null;
        if ($orderId && $itemId && $type) {
            $tableName = '';
            switch ($type) {
                case 'lumber':
                    $tableName = 'orderlumber';
                    break;
                case 'furniture':
                    $tableName = 'orderfurniture';
                    break;
                case 'customized':
                    $tableName = 'ordercustomizedfurniture';
                    break;
            }
            
            if ($tableName) {
                $dateSql = "SELECT date FROM $tableName WHERE orderId = ? AND itemId = ? AND driverId = ?";
                $dateStmt = $conn->prepare($dateSql);
                $dateStmt->bind_param("iii", $orderId, $itemId, $driverId);
                $dateStmt->execute();
                $dateResult = $dateStmt->get_result();
                
                if ($dateResult->num_rows > 0) {
                    $dateRow = $dateResult->fetch_assoc();
                    $date = $dateRow['date'];
                }
                $dateStmt->close();
            }
        }
        
        echo json_encode([
            'status' => 'success',
            'driver' => [
                'driverId' => $driver['driverId'],
                'name' => $driver['name'] ?? "Driver #$driverId",
                'phone' => $driver['phone'] ?? 'N/A',
                'vehicleNo' => $driver['vehicleNo'] ?? 'N/A',
                'date' => $date
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