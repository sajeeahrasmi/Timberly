<?php
session_start();

// Check if user is logged in and has manager role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    // Not logged in or not a manager - redirect to login
    echo "<script>
        alert('Please login to access this page');
        window.location.href='../login.html';
    </script>";
    exit();
}
?>