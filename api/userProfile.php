<?php

session_start();
include '../../config/db_connection.php'; // DB connection

// Get logged-in user ID (fallback to 1 for testing)
// $user_id = $_SESSION['user_id'] ?? 1;

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
} else {
    // error handling: user not logged in
    // e.g., redirect to login page or show message
    header("Location: login.php");
    exit();
}


// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name']; // Corrected variable name to $name to match form input name
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Corrected table and ID column
    $updateQuery = "UPDATE user SET name='$name', email='$email', phone='$phone', address='$address' WHERE userID='$userId'";
    mysqli_query($conn, $updateQuery);
}

// Fetch user data
$query = "SELECT name, email, phone, address FROM user WHERE userID=$userId";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>