<?php

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $name = $_POST['name'];
    $vehicleNo = $_POST['vehicleNo'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $home_address = $_POST['home_address'];
    $work_address = $_POST['work_address'];
    
    if (empty($name) || empty($vehicleNo) || empty($email) || empty($phone) || empty($home_address) || empty($work_address)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $query = "INSERT INTO drivers (name, vehicleNo email, phone, home_address, work_address) 
              VALUES ('$name', '$vehicleNo' '$email', '$phone', '$home_address', '$work_address')";
    
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true, 'message' => 'Driver created successfully']);
    } else {
        
        echo json_encode(['success' => false, 'message' => 'Error creating driver: ' . mysqli_error($conn)]);
    }
}