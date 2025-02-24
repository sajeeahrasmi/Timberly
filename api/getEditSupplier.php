<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = $_GET['supplier_id'];
    $query = "SELECT name, phone, email, address FROM user WHERE userId = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Error fetching supplier data: ' . mysqli_error($conn)]);
        exit;
    }

    $data = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_GET['supplier_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $query1 = "
        UPDATE user
        SET name = '$name', phone = '$phone', address = '$address', email = '$email'
        WHERE userId = '$user_id';
    ";

    $result1 = mysqli_multi_query($conn, $query1);

    if (!$result1) {
        echo json_encode(['success' => false, 'message' => 'Error updating supplier data: ' . mysqli_error($conn)]);
        exit;
    }
    header("Location: ../public/admin/suppliers.php");
}

?>