<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = $_GET['customer_id'];
    $query = "SELECT name, phone, email, address, image FROM user WHERE userId = '$user_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Error fetching customer data: ' . mysqli_error($conn)]);
        exit;
    }

    $data = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_GET['customer_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $upload_dir = '../public/images/';
    $image_filename = null;

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['profile_image']['tmp_name'];
        $image_name = basename($_FILES['profile_image']['name']);
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

        $new_image_name = 'customer_' . $user_id . '.' . $image_ext;
        $target_path = $upload_dir . $new_image_name;

        if (move_uploaded_file($image_tmp, $target_path)) {
            $image_filename = $new_image_name;
        } else {
            echo json_encode(['success' => false, 'message' => 'Image upload failed.']);
            exit;
        }
    }

    $query1 = "
        UPDATE user
        SET name = '$name',
            phone = '$phone',
            email = '$email',
            address = '$address'";

    if ($image_filename) {
        $query1 .= ", image = '$image_filename'";
    }

    $query1 .= " WHERE userId = '$user_id'";

    $result1 = mysqli_query($conn, $query1);

    if (!$result1) {
        echo json_encode(['success' => false, 'message' => 'Error updating customer data: ' . mysqli_error($conn)]);
        exit;
    }

    header("Location: ../public/admin/customers.php");
    exit;
}
?>