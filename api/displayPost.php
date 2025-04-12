<?php
include '../../config/db_connection.php'; // Ensure you have the correct database connection
session_start();

$sql = "SELECT * FROM crudpost"; // Query to get posts
$posts = "SELECT * FROM crudpost WHERE supplierId = '{$_SESSION['userId']}'";

$result = mysqli_query($conn, $posts);

if (!$result) {
    die("Error fetching posts: " . mysqli_error($conn));
}
?>