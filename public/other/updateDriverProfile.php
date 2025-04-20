<?php
session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

// Get the updated profile data
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';

// Check if the fields are not empty
if ($email && $phone && $address) {
    include '../../config/db_connection.php';

    // Prepare the update query
    $query = "UPDATE user SET email = ?, phone = ?, address = ? WHERE userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $email, $phone, $address, $userId);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='driverProfile.php';</script>";
    } else {
        echo "<script>alert('An error occurred while updating the profile.'); window.location.href='driverProfile.php';</script>";
    }
} else {
    echo "<script>alert('Please fill in all fields.'); window.location.href='driverProfile.php';</script>";
}
?>
