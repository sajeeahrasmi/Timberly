<?php

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $vehicleNo = $_POST['vehicleNo'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    if (empty($name) || empty($vehicleNo) || empty($email) || empty($phone) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $checkQuery = "SELECT * FROM user WHERE email = '$email' OR phone = '$phone'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or phone already exists.']);
        exit;
    }
    
    // Insert into 'user' table
    $query = "INSERT INTO user (name, address, phone, email, role) 
              VALUES ('$name', '$address', '$phone', '$email', 'driver')";

    if (mysqli_query($conn, $query)) {
        // Insert into 'driver' table
        $query2 = "INSERT INTO driver (driverId, vehicleNo) 
                   VALUES (LAST_INSERT_ID(), '$vehicleNo')";
        if (mysqli_query($conn, $query2)) {
            header("Location: ../public/admin/addDriver.php");
        } else {
            echo json_encode(['success' => false, 'message' => 'Error creating driver: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating driver: ' . mysqli_error($conn)]);
    }
}
?>