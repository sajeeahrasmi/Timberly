<?php
session_start(); 
include '../../config/db_connection.php';

if (!isset($_SESSION['userId'])) {
    echo "Error: Supplier not logged in.";
    exit();
}

$supplierId = $_SESSION['userId'];
$orders = [];

// Filters from GET
$filterCategory = $_GET['category'] ?? '';
$filterType = $_GET['type'] ?? '';
$filterFrom = $_GET['from'] ?? '';
$filterTo = $_GET['to'] ?? '';

// ---- TIMBER ----
if ($filterCategory === '' || $filterCategory === 'Timber') {
    $query = "SELECT id, category, type, quantity, unitprice, totalprice, postdate 
              FROM pendingtimber 
              WHERE supplierId = ? AND is_approved = '1'";

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
            'category' => $row['category'],
            'type' => $row['type'],
            'quantity' => $row['quantity'],
            'unitprice' => $row['unitprice'],
            'totalprice' => $row['totalprice'],
            'postdate' => $row['postdate'],
            'is_approved' => '1'
        ];
    }
}

// ---- LUMBER ----
if ($filterCategory === '' || $filterCategory === 'Lumber') {
    $query = "SELECT id, type, quantity, unitprice, totalprice, postdate 
              FROM pendinglumber 
              WHERE supplierId = ? AND is_approved = '1'";

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
            'is_approved' => '1'
        ];
    }
}

// Optional: Sort by date descending
usort($orders, fn($a, $b) => strtotime($b['postdate']) - strtotime($a['postdate']));
?>
