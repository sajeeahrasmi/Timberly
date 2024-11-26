<?php
// Database connection
include 'db.php';
// Fetch pending suppliers
function getPendingSuppliers() {
    global $conn;
    $sql = "SELECT userId, name, address, phone, email FROM user WHERE role = 'supplier' AND status = 'Not Approved'";
    $result = $conn->query($sql);
    
    $newsuppliers = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $suppliers[] = array(
                'id' => $row['userId'],
                'name' => $row['name'],
                'address' => $row['address'],
                'contact' => $row['phone'],
                'email' => $row['email']
            );
        }
    }
    return $newsuppliers;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    if (isset($_POST['approve_supplier'])) {
        $supplierId = $_POST['supplier_id'];
        
        // Update supplier status
        $sql = "UPDATE user SET status = 'Approved' WHERE userId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $supplierId);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Supplier approved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error approving supplier']);
        }
        
        $stmt->close();
        exit;
    } elseif (isset($_POST['reject_supplier'])) {
        // Add rejection logic if needed
        echo json_encode(['success' => true, 'message' => 'Supplier rejected']);
        exit;
    }
}

// Get suppliers for initial page load
$newsuppliers = getPendingSuppliers();
?>