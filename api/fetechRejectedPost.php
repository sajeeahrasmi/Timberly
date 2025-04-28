<?php
session_start();
include '../../config/db_connection.php';

if (!isset($_SESSION['userId'])) {
    echo "Error: Supplier not logged in.";
    exit();
}

$supplierId = $_SESSION['userId'];
$orders = [];
$timberRevenue = 0;
$lumberRevenue = 0;

// Filters from GET
$filterCategory = $_GET['category'] ?? '';
$filterType = $_GET['type'] ?? '';
$filterMonth = $_GET['from'] ?? '';
$filterFrom = '';
$filterTo = '';

// Convert selected month (YYYY-MM) to full date range
if (!empty($filterMonth)) {
    $startDate = new DateTime($filterMonth . '-01');
    $filterFrom = $startDate->format('Y-m-d');
    $filterTo = $startDate->format('Y-m-t'); // Last day of the selected month
}

// ---- TIMBER ----
if ($filterCategory === '' || $filterCategory === 'Timber') {
    $query = "SELECT id, category, type, quantity, unitprice, totalprice, postdate 
              FROM pendingtimber 
              WHERE supplierId = ? AND status = 'Rejected'";

    $params = [$supplierId];
    $types = "i"; 

    if (!empty($filterType)) {
        $query .= " AND type LIKE ?";
        $params[] = "%$filterType%";
        $types .= "s";
    }

    if (!empty($filterFrom)) {
        $query .= " AND postdate >= ?";
        $params[] = $filterFrom;
        $types .= "s";
    }

    if (!empty($filterTo)) {
        $query .= " AND postdate <= ?";
        $params[] = $filterTo;
        $types .= "s";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'id' => $row['id'],
            'category' => 'Timber',
            'type' => $row['type'],
            'quantity' => $row['quantity'],
            'unitprice' => $row['unitprice'],
            'totalprice' => $row['totalprice'],
            'postdate' => $row['postdate'],
            'status' => 'Rejected'
        ];
        $timberRevenue += $row['totalprice'];
    }
}

// ---- LUMBER ----
if ($filterCategory === '' || $filterCategory === 'Lumber') {
    $query = "SELECT id, type, quantity, unitprice, totalprice, postdate 
              FROM pendinglumber 
              WHERE supplierId = ? AND status = 'Rejected'";

    $params = [$supplierId];
    $types = "i";

    if (!empty($filterType)) {
        $query .= " AND type LIKE ?";
        $params[] = "%$filterType%";
        $types .= "s";
    }

    if (!empty($filterFrom)) {
        $query .= " AND postdate >= ?";
        $params[] = $filterFrom;
        $types .= "s";
    }

    if (!empty($filterTo)) {
        $query .= " AND postdate <= ?";
        $params[] = $filterTo;
        $types .= "s";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'id' => $row['id'],
            'category' => 'Lumber',
            'type' => $row['type'],
            'quantity' => $row['quantity'],
            'unitprice' => $row['unitprice'],
            'totalprice' => $row['totalprice'],
            'postdate' => $row['postdate'],
            'status' => 'Rejected'
        ];
        $lumberRevenue += $row['totalprice'];
    }
}

// Sort orders by postdate descending
usort($orders, fn($a, $b) => strtotime($b['postdate']) - strtotime($a['postdate']));

// Optional total revenue
$totalRevenue = $timberRevenue + $lumberRevenue;
?>
