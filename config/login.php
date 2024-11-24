<?php
session_start();
include 'db_connection.php'; // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Modified query to also check status for suppliers
    $stmt = $conn->prepare("SELECT login.userId, user.name, user.role, user.status FROM login 
                            JOIN user ON login.userId = user.userId 
                            WHERE login.username = ? AND login.password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Check if supplier is approved
        if ($row['role'] === 'supplier' && $row['status'] !== 'Approved') {
            echo "<script>
                alert('Your account is pending approval. Please contact administrator.');
                window.location.href='../public/landingPage.html';
            </script>";
            exit();
        }
        
        // If not a supplier or if supplier is approved, proceed with login
        $_SESSION['userId'] = $row['userId'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        switch ($row['role']) {
            case 'customer':
                header("Location: ../public/customer/customerDashboard.html");
                break;
            case 'manager':
                header("Location: ../public/manager/admin.php");
                break;
            case 'supplier':
                header("Location: ../public/supplier/Dashboard/dashboard.html");
                break;
            case 'admin':
                header("Location: ../public/admin/index.php");
                break;
            case 'driver':
                header("Location: ../public/other/driver.html");
                break;
            case 'designer':
                header("Location: ../public/other/designer.html");
                break;
            default:
                echo "<script>
                    alert('Invalid user role');
                    window.location.href='../public/login.html';
                </script>";
                break;
        }
    } else {
        echo "<script>
            alert('Invalid username or password');
            window.location.href='../public/login.html';
        </script>";
    }
    $stmt->close();
    $conn->close();
}
?>
