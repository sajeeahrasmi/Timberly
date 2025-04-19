<?php
include '../../config/db_connection.php';
session_start();

// Validate ID
if (!isset($_GET['id']) || !isset($_GET['category'])) {
    echo "Invalid request.";
    exit;
}

$id = intval($_GET['id']);
$category = $_GET['category'];
$table = ($category === 'Lumber') ? 'pendinglumber' : 'pendingtimber';

// Fetch existing post data
$sql = "SELECT * FROM $table WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Post not found.";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Assign values
$type = $row['type'];
$quantity = $row['quantity'];
$price = $row['unitprice'];
$info = $row['info'];
$image = $row['image'];

if ($category === 'Lumber') {
    $length = $row['length'];
    $width = $row['width'];
    $height = $row['thickness'];
} else {
    $diameter = $row['diameter'];
}

// Handle update form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $info = mysqli_real_escape_string($conn, $_POST['info']);

    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    if ($category === 'Lumber') {
        $length = mysqli_real_escape_string($conn, $_POST['length']);
        $width = mysqli_real_escape_string($conn, $_POST['width']);
        $height = mysqli_real_escape_string($conn, $_POST['height']);

        $sql = "UPDATE pendinglumber SET type='$type', length='$length', width='$width', thickness='$height', quantity='$quantity', unitprice='$price', info='$info', image='$image' WHERE id=$id";
    } else {
        $diameter = mysqli_real_escape_string($conn, $_POST['diameter']);

        $sql = "UPDATE pendingtimber SET type='$type', diameter='$diameter', quantity='$quantity', unitprice='$price', info='$info', image='$image' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: displayPost.php");
        exit;
    } else {
        echo "Error updating post: " . mysqli_error($conn);
    }
}
?>
