<?php
include '../../config/db_connection.php'; // Ensure your database connection is working
session_start(); // Start the session

// Check if the `id` parameter is passed in the URL
if (isset($_GET['id'])) {
    // Get the `id` parameter
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Fetch the post details from the database
    $sql = "SELECT * FROM pendinglumber WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Assign values to variables
        // $category = $row['category'];
        // $type = $row['type'];
        $length = $row['length'];
        $width = $row['width'];
        $thickness = $row['thickness'];
        $quantity = $row['quantity'];
        $price = $row['unitprice'];
        $info = $row['info'];
        $image = $row['image'];
    } else {
        // If no post found
        echo "Post not found.";
        exit; // Stop further execution
    }
} else {
    // If 'id' is not passed
    echo "Invalid request. No post ID provided.";
    exit;
}

// Handle form submission for updating the post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $category = mysqli_real_escape_string($conn, $_POST['category']);
    // $type = mysqli_real_escape_string($conn, $_POST['type']);
    $length = mysqli_real_escape_string($conn, $_POST['length']);
    $width = mysqli_real_escape_string($conn, $_POST['width']);
    $thickness = mysqli_real_escape_string($conn, $_POST['thickness']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $info = mysqli_real_escape_string($conn, $_POST['info']);

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Update the record in the database
    $sql = "UPDATE pendinglumber 
            SET length = '$length', 
                width = '$width', thickness = '$thickness', quantity = '$quantity', unitprice = '$price',
                info = '$info', image = '$image' 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Post updated successfully!";
        header('Location: displayPost.php'); // Redirect back to the display page
        exit;
    } else {
        echo "Error updating post: " . mysqli_error($conn);
    }
}
?> 