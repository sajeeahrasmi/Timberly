<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['role'])) {
    
    echo "<script>
        alert('Please login to access this page');
        window.location.href='../login.php';
    </script>";
    exit();
}

?>