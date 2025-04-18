<?php
    include('db.php');

    // Initialize variables
    $message = '';

    // Handle POST requests
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['timberId'])) {
        $timberId = mysqli_real_escape_string($conn, $_GET['timberId']);
        $query = "SELECT * FROM timber WHERE timberId = ?";
        
        // Use prepared statement
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $timberId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (!$result) {
            $message = 'Error fetching timber data: ' . mysqli_error($conn);
        } else {
            $timber = mysqli_fetch_assoc($result);
            if (!$timber) {
                $message = 'Lumber not found';
            }
        }
    }
?>