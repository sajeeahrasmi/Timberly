<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $checkQuery = "SELECT * FROM user WHERE email = '$email' OR phone = '$phone'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or phone already exists.']);
        exit;
    }
    
    $query = "INSERT INTO user (name, address, phone, email, role) 
              VALUES ('$name', '$address', '$phone', '$email', 'customer')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../public/admin/customers.php");
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating customer: ' . mysqli_error($conn)]);
    }
}
?>