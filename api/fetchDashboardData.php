<?php
session_start(); // Start the session to access session variables
include '../../config/db_connection.php'; // Include the database connection

// Check if supplier is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: ../../config/login.php"); // Redirect to login page if not logged in
    exit();
}

// Supplier ID from session
$supplierId = $_SESSION['userId'];

// Initialize variables for counts
$totalOrders = 0;
$approvedOrders = 0;
$pendingOrders = 0;
$rejectedOrders = 0;

// Fetch total orders (both approved and pending) from both pendingtimber and pendinglumber
$sqlTotal = "SELECT COUNT(*) AS total_orders 
             FROM (
                 SELECT id FROM pendingtimber WHERE supplierId = ?
                 UNION ALL
                 SELECT id FROM pendinglumber WHERE supplierId = ?
             ) AS combined";
$stmtTotal = $conn->prepare($sqlTotal);
$stmtTotal->bind_param('ii', $supplierId, $supplierId);
$stmtTotal->execute();
$resultTotal = $stmtTotal->get_result();
if ($resultTotal->num_rows > 0) {
    $totalOrders = $resultTotal->fetch_assoc()['total_orders'];
}

// Fetch approved orders (is_approved = 1) from both pendingtimber and pendinglumber
$sqlApproved = "SELECT COUNT(*) AS approved_orders 
                FROM (
                    SELECT id FROM pendingtimber WHERE supplierId = ? AND status = 'Approved'
                    UNION ALL
                    SELECT id FROM pendinglumber WHERE supplierId = ? AND status = 'Approved'
                ) AS approved_combined";
$stmtApproved = $conn->prepare($sqlApproved);
$stmtApproved->bind_param('ii', $supplierId, $supplierId);
$stmtApproved->execute();
$resultApproved = $stmtApproved->get_result();
if ($resultApproved->num_rows > 0) {
    $approvedOrders = $resultApproved->fetch_assoc()['approved_orders'];
}

// Fetch pending orders (is_approved = 0) from both pendingtimber and pendinglumber
$sqlPending = "SELECT COUNT(*) AS pending_orders 
               FROM (
                   SELECT id FROM pendingtimber WHERE supplierId = ? AND status = 'Pending'
                   UNION ALL
                   SELECT id FROM pendinglumber WHERE supplierId = ? AND status = 'Pending'
               ) AS pending_combined";
$stmtPending = $conn->prepare($sqlPending);
$stmtPending->bind_param('ii', $supplierId, $supplierId);
$stmtPending->execute();
$resultPending = $stmtPending->get_result();
if ($resultPending->num_rows > 0) {
    $pendingOrders = $resultPending->fetch_assoc()['pending_orders'];
}

//Fetch Rejected orders (status = 'Rejected') from both pendingtimber and pendinglumber
$sqlRejected = "SELECT COUNT(*) AS rejected_orders 
                 FROM (
                     SELECT id FROM pendingtimber WHERE supplierId = ? AND status = 'Rejected'
                     UNION ALL
                     SELECT id FROM pendinglumber WHERE supplierId = ? AND status = 'Rejected'
                 ) AS rejected_combined";
$stmtRejected = $conn->prepare($sqlRejected);
$stmtRejected->bind_param('ii', $supplierId, $supplierId);
$stmtRejected->execute();
$resultRejected = $stmtRejected->get_result();
if ($resultRejected->num_rows > 0) {
    $rejectedOrders = $resultRejected->fetch_assoc()['rejected_orders'];
} else {
    $rejectedOrders = 0; // Default to 0 if no rejected orders found
}


// Fetch recent approved orders from both tables (limit to 6 for dashboard view)
$sqlRecentApproved = "SELECT id, category, type, quantity, postdate 
                      FROM (
                          SELECT id, category, type, quantity, postdate FROM pendingtimber WHERE supplierId = ? AND status = 'Approved'
                          UNION ALL
                          SELECT id, 'Lumber' AS category, type, quantity, postdate FROM pendinglumber WHERE supplierId = ? AND status = 'Approved'
                      ) AS recent_orders 
                      ORDER BY postdate DESC LIMIT 6";
$stmtRecentApproved = $conn->prepare($sqlRecentApproved);
$stmtRecentApproved->bind_param('ii', $supplierId, $supplierId);
$stmtRecentApproved->execute();
$resultRecentApproved = $stmtRecentApproved->get_result();
$recentOrders = [];
if ($resultRecentApproved->num_rows > 0) {
    while ($row = $resultRecentApproved->fetch_assoc()) {
        $recentOrders[] = [
            'id' => $row['id'],
            'category' => $row['category'],
            'type' => $row['type'],
            'quantity' => $row['quantity'],
            'postdate' => $row['postdate']
        ];
    }
}
?>

