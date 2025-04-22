<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['role'])) {
    // Not logged in - redirect to login
    echo "<script>
        alert('Please login to access this page');
        window.location.href='../login.php';
    </script>";
    exit();
}

?>