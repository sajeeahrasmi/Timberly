<?php
include '../db_connection.php';

header('Content-Type: application/json');

$type = isset($_GET['type']) ? $_GET['type'] : null;
$length = isset($_GET['length']) ? $_GET['length'] : null;
$width = isset($_GET['width']) ? $_GET['width'] : null;

$response = [];

if ($type && !$length) {
    $stmt = $conn->prepare("SELECT DISTINCT length FROM lumber WHERE type = ?");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response[] = $row['length'];
    }
} elseif ($type && $length && !$width) {
    $stmt = $conn->prepare("SELECT DISTINCT width FROM lumber WHERE type = ? AND length = ?");
    $stmt->bind_param("sd", $type, $length);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response[] = $row['width'];
    }
} elseif ($type && $length && $width) {
    $stmt = $conn->prepare("SELECT DISTINCT thickness FROM lumber WHERE type = ? AND length = ? AND width = ?");
    $stmt->bind_param("sdd", $type, $length, $width);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response[] = $row['thickness'];
    }
} elseif ($type && $length && $width) {
    $stmt = $conn->prepare("SELECT MAX(qty) as max_qty FROM lumber WHERE type = ? AND length = ? AND width = ?");
    $stmt->bind_param("sdd", $type, $length, $width);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $response['max_qty'] = $row['max_qty'];
}

echo json_encode($response);
?>
