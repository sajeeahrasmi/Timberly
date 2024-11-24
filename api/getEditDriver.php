<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $driver_id = $_GET['driver_id'];
    $query = "SELECT name, vehicleNo, phone, email, address FROM driverdetails WHERE userId = '$driver_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Error fetching driver data: ' . mysqli_error($conn)]);
        exit;
    }

    $data = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $driver_id = $_GET['driver_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = "UPDATE driverdetails SET name = '$name', phone = '$phone', address = '$address' WHERE userId = '$driver_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Error updating driver data: ' . mysqli_error($conn)]);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Driver data updated successfully']);
}

?>