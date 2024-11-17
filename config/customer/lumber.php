<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Timberly";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize response
$response = [
    "lengths" => [],
    "widths" => [],
    "thicknesses" => [],
    "qtys" => null,
    "price" => null,
    "lumberId" => null
];

// Get parameters from the request
$type = $_GET['type'] ?? null;
$length = $_GET['length'] ?? null;
$width = $_GET['width'] ?? null;
$thickness = $_GET['thickness'] ?? null;

if ($type && !$length) {
    // Fetch lengths based on type
    $stmt = $conn->prepare("SELECT DISTINCT length FROM lumber WHERE type = ?");
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response["lengths"][] = $row['length'];
    }
} elseif ($type && $length && !$width) {
    // Fetch widths based on type and length
    $stmt = $conn->prepare("SELECT DISTINCT width FROM lumber WHERE type = ? AND length = ?");
    $stmt->bind_param("sd", $type, $length);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response["widths"][] = $row['width'];
    }
} elseif ($type && $length && $width && !$thickness) {
    // Fetch thicknesses based on type, length, and width
    $stmt = $conn->prepare("SELECT DISTINCT thickness FROM lumber WHERE type = ? AND length = ? AND width = ?");
    $stmt->bind_param("sdd", $type, $length, $width);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response["thicknesses"][] = $row['thickness'];
    }
} elseif ($type && $length && $width && $thickness) {
    // Fetch quantity based on all parameters
    $stmt = $conn->prepare("SELECT qty, unitPrice, lumberId FROM lumber WHERE type = ? AND length = ? AND width = ? AND thickness = ?");
    $stmt->bind_param("sddd", $type, $length, $width, $thickness);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response["qtys"] = $row['qty'];
        $response["price"] = $row['unitPrice'];
        $response["lumberId"] = $row['lumberId'];
    } else {
        $response["qtys"] = "Not Available"; 
        $response["price"] = "Not Available";
        $response["lumberId"] = "Not Available";
    }
}

// Close the connection
$stmt->close();
$conn->close();

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
