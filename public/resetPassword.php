<?php
require '../config/db_connection.php';

$token = $_GET['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container" style="width: 320px">
        <form action="../config/updatePassword.php" method="POST">
            <h2>Enter New Password</h2>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="form-group">
                <input type="password" name="new_password" placeholder="New Password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                title="Password must be at least 8 characters long and contain at least one letter and one number." required>

                <input type="password" name="re_new_password" placeholder="Re-enter Password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                title="Password must be at least 8 characters long and contain at least one letter and one number." required>
            </div>
            <button type="submit" class="button solid">Reset Password</button>
        </form>
    </div>
</body>
</html>