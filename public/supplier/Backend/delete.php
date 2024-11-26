<?php
// Include the database connection file
include 'db.php';

// Check if the 'id' is passed in the URL
if (isset($_GET['id'])) {
    // Get the post ID from the URL
    $post_id = $_GET['id'];

    // Write the SQL query to delete the post from the database
    $sql = "DELETE FROM crudpost WHERE id = $post_id";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        // Redirect back to the display page with a success message
        header("Location: display.php?message=Post deleted successfully");
        exit();
    } else {
        // If the query failed, display an error message
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // If the ID is not passed, show an error message
    echo "Invalid request. No post ID found.";
}

// Close the database connection
mysqli_close($con);
?>
