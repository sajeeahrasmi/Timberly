<?php
include '../../config/db_connection.php';
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'supplier') {
    header("Location: /Supplier/login.php");
    exit();
}

// Display PHP errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Queries for both lumber and timber posts
$lumberQuery = "SELECT * FROM pendinglumber WHERE supplierId = '{$_SESSION['userId']}' AND status = 'Pending' AND category = 'Lumber'";
$timberQuery = "SELECT * FROM pendingtimber WHERE supplierId = '{$_SESSION['userId']}' AND status = 'Pending' AND category = 'Timber'";

$lumberResult = mysqli_query($conn, $lumberQuery);
$timberResult = mysqli_query($conn, $timberQuery);

// Handle delete request
if (isset($_GET['delete']) && isset($_GET['id']) && isset($_GET['type'])) {
    $post_id = intval($_GET['id']);
    $type = $_GET['type'];
    $redirectUrl = "displayPost.php#$type";

    if ($type === 'lumber') {
        $delete_sql = "DELETE FROM pendinglumber WHERE id = $post_id";
    } elseif ($type === 'timber') {
        $delete_sql = "DELETE FROM pendingtimber WHERE id = $post_id";
    }

    if (isset($delete_sql) && mysqli_query($conn, $delete_sql)) {
        echo "<script>
                alert('Post deleted successfully!');
                window.location.href = '$redirectUrl';
              </script>";
        exit();
    } else {
        $error = mysqli_error($conn);
        echo "<script>
                alert('Error deleting post: $error');
                window.location.href = '$redirectUrl';
              </script>";
        exit();
    }
}
?>