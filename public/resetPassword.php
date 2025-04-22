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
    <div class="container">
        <form action="../config/updatePassword.php" method="POST">
            <h2>Enter New Password</h2>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </div>
            <button type="submit" class="button solid">Reset Password</button>
        </form>
    </div>
</body>
</html>