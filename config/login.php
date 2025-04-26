<?php
session_start();
include 'db_connection.php'; // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Fetch the login record
    $stmt = $conn->prepare("SELECT login.userId, login.password, user.name, user.role, user.status, user.is_verified 
                            FROM login 
                            JOIN user ON login.userId = user.userId 
                            WHERE login.username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHash = $row['password'];

        // Verify password using password_verify
        if (password_verify($inputPassword, $storedHash)) {

            if ($row['is_verified'] == 0) {
                echo "<script>
                    window.location.href='../public/newUserReset.php?userId=" . $row['userId'] . "';
                </script>";
                exit();
            }

            if ($row['role'] === 'supplier' && $row['status'] !== 'Approved') {
                echo "<script>
                    alert('Your account is pending approval. Please contact administrator.');
                    window.location.href='../public/landingPage.php';
                </script>";
                exit();
            }

            $_SESSION['userId'] = $row['userId'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            switch ($row['role']) {
                case 'customer':
                    header("Location: ../public/customer/customerDashboard.php");
                    break;
                case 'manager':
                    header("Location: ../public/manager/admin.php");
                    break;
                case 'supplier':
                    header("Location: ../public/supplier/dashboard.php");
                    break;
                case 'admin':
                    header("Location: ../public/admin/index.php");
                    break;
                case 'driver':
                    header("Location: ../public/other/driver.php");
                    break;
                case 'designer':
                    header("Location: ../public/other/designer.php");
                    break;
                default:
                    echo "<script>
                        alert('Invalid user role');
                        window.location.href='../public/login.php';
                    </script>";
                    break;
            }
        } else {
            echo "<script>
                alert('Invalid username or password');
                window.location.href='../public/login.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Invalid username or password');
            window.location.href='../public/login.php';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
