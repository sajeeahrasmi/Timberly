<?php
    include "../config/db_connection.php"; // Assumes $conn = new mysqli(...)

    // Get user ID from URL
    $userId = $_GET['userId'] ?? '';

    if (!$userId) {
        echo "<script>
            alert('Invalid user ID.');
            window.location.href = 'landingPage.php';
        </script>";
        exit();
    }

    // Prepare statement to check if user exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE userId = ?");
    $stmt->bind_param("i", $userId);  // "i" = integer
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>
            alert('Invalid user ID.');
            window.location.href = 'landingPage.php';
        </script>";
        exit();
    }

    // If form submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST['username'];
        $newPassword = $_POST['new_password'];
        $reNewPassword = $_POST['re_new_password'];

        // Check if fields are empty
        if (empty($username) || empty($newPassword) || empty($reNewPassword)) {
            die("Missing username or password");
        }

        // Check if passwords match
        if ($newPassword !== $reNewPassword) {
            echo "<script>
                    alert('Passwords do not match.');
                    window.location.href='newUserReset.php?userId=$userId';
                </script>";
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Step 1: Update username and password in login table
        $stmt = $conn->prepare("UPDATE login SET username = ?, password = ? WHERE userId = ?");
        $stmt->bind_param("ssi", $username, $hashedPassword, $userId);
        $stmt->execute();

        // Step 2: Mark user as verified
        $stmt = $conn->prepare("UPDATE user SET is_verified = 1 WHERE userId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        echo "<script>
                alert('Credentials updated successfully. You can now log in.');
                window.location.href='login.php';
            </script>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly User</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <form method="POST">
                <h2>Enter New Credentials</h2>
                <div class="form-group">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                    <input type="password" name="new_password" placeholder="New password"
                        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                        title="Password must be at least 8 characters long and contain at least one letter and one number." required>
                    <input type="password" name="re_new_password" placeholder="Re-enter password"
                        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                        title="Password must be at least 8 characters long and contain at least one letter and one number." required>
                </div>
                <button type="submit" class="button solid">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>