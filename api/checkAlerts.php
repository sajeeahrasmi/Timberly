<?php


header('Content-Type: application/json');


include 'db.php';

try {
  
    $stmt = $conn->prepare("SELECT alert_id, alert_type, message, created_at 
                            FROM sys_alerts 
                            WHERE is_read = 0 
                            ORDER BY created_at DESC");
    $stmt->execute();
    
    $alerts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    
    if (count($alerts) > 0) {
        $alertIds = array_column($alerts, 'alert_id');
        $placeholders = implode(',', array_fill(0, count($alertIds), '?'));

        
        $updateStmt = $conn->prepare("UPDATE sys_alerts SET is_read = 1 WHERE alert_id IN ($placeholders)");
        
        
        $types = str_repeat('i', count($alertIds)); 
        $updateStmt->bind_param($types, ...$alertIds);
        $updateStmt->execute();
    }

    
    echo json_encode([
        'status' => 'success',
        'alerts' => $alerts,
        'count' => count($alerts)
    ]);
    
} catch (Exception $e) {
    // Handle errors
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
