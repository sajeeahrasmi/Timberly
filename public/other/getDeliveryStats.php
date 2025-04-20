<?php

function getDeliveryStats($conn, $driverId) {
    $stats = [
        'todayDeliveries' => 0,
        'totalDeliveries' => 0
    ];

    $today = date('Y-m-d');
    $tables = ['orderfurniture', 'ordercustomizedfurniture', 'orderlumber'];

    foreach ($tables as $table) {
        // Total Deliveries
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM $table WHERE driverId = ?");
        if ($stmt) {
            $stmt->bind_param("i", $driverId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $stats['totalDeliveries'] += $row['count'];
            }
            $stmt->close();
        }

        // Today's Deliveries
        $stmtToday = $conn->prepare("SELECT COUNT(*) as count FROM $table WHERE driverId = ? AND DATE(date) = ?");
        if ($stmtToday) {
            $stmtToday->bind_param("is", $driverId, $today);
            $stmtToday->execute();
            $resultToday = $stmtToday->get_result();
            if ($rowToday = $resultToday->fetch_assoc()) {
                $stats['todayDeliveries'] += $rowToday['count'];
            }
            $stmtToday->close();
        }
    }

    return $stats;
}
