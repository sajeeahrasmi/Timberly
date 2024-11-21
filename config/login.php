

<?php
session_start();
include 'db_connection.php'; // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT login.userId, user.name, user.role FROM login 
                            JOIN user ON login.userId = user.userId 
                            WHERE login.username = ? AND login.password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role']; // Could be 'customer', 'manager', or 'supplier'

        // Redirect based on role
        if ($row['role'] === 'customer') {
            header("Location: ../public/customer/customerDashboard.html");
        } elseif ($row['role'] === 'manager') {
            header("Location: ../public/manager/admin.php");
        } elseif ($row['role'] === 'supplier') {
            header("Location: ../public/supplier/Dashboard/dashboard.html");
        } elseif ($row['role'] === 'admin') {
            header("Location: ../public/admin/index.php");
        }elseif ($row['role'] === 'driver') {
            header("Location: ../public/other/driver.html");
        }elseif ($row['role'] === 'designer') {
            header("Location: ../public/other/designer.html");
        }
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='../public/login.html';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
