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
    $vehicleNo = $_POST['vehicleNo'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query1 = "
        UPDATE user 
        SET name = '$name', phone = '$phone', address = '$address' 
        WHERE userId = '$driver_id';

        UPDATE driver 
        SET vehicleNo = '$vehicleNo' 
        WHERE driverId = '$driver_id';
    ";

    $result1 = mysqli_multi_query($conn, $query1);

    if (!$result1) {
        echo json_encode(['success' => false, 'message' => 'Error updating driver data: ' . mysqli_error($conn)]);
        exit;
    }
    header("Location: ../public/admin/drivers.php");
}

?>