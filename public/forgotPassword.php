<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <form action="../config/sendResetLink.php" method="POST">
            <h2>Reset Password</h2>
            <div class="form-group">
                <label for="email">Enter your registered email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit" class="button solid">Send Reset Link</button>
        </form>
    </div>
</body>
</html>