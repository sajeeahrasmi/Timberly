<?php
include 'db.php';


    $user_id = $_GET['customer_id'];
    $query = "SELECT name, phone, email, address FROM user WHERE userId = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Error fetching customer data: ' . mysqli_error($conn)]);
        exit;
    }

    $data = mysqli_fetch_assoc($result);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    if ($password !== $re_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query1 = "
        UPDATE user
        SET name = '$name',
            phone = '$phone',
            email = '$email',
            address = '$address'
            WHERE userId = '$user_id'";

    $result1 = mysqli_query($conn, $query1);

    if (!$result1) {
        echo json_encode(['success' => false, 'message' => 'Error updating customer data: ' . mysqli_error($conn)]);
        exit;
    }

    $query2 = "
        UPDATE login
        SET password = '$password'
        WHERE userId = '$user_id'";
    $result2 = mysqli_query($conn, $query2);

    if (!$result2) {
        echo json_encode(['success' => false, 'message' => 'Error updating password: ' . mysqli_error($conn)]);
        exit;
    }


    header("Location: ../public/admin/customers.php");
    exit;
}
?>