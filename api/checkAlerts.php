<?php
// alerts_endpoint.php - Endpoint for checking lumber inventory alerts

header('Content-Type: application/json');

// Use existing DB connection
include 'db.php';

try {
    // Check for new alerts (unread alerts)
    $stmt = $conn->prepare("SELECT alert_id, alert_type, message, created_at 
                            FROM sys_alerts 
                            WHERE is_read = 0 
                            ORDER BY created_at DESC");
    $stmt->execute();
    
    $alerts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // If alerts were found and returned, mark them as read
    if (count($alerts) > 0) {
        $alertIds = array_column($alerts, 'alert_id');
        $placeholders = implode(',', array_fill(0, count($alertIds), '?'));

        // Prepare the statement with dynamic placeholders
        $updateStmt = $conn->prepare("UPDATE sys_alerts SET is_read = 1 WHERE alert_id IN ($placeholders)");
        
        // Dynamically bind the alert IDs
        $types = str_repeat('i', count($alertIds)); // all integers
        $updateStmt->bind_param($types, ...$alertIds);
        $updateStmt->execute();
    }

    // Return the alerts as JSON
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
