<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container" style="max-width: 320px">
        <form action="../config/sendResetLink.php" method="POST" style="padding: 20px">
            <h2 style="text-align: left">Reset Password</h2>
            <div class="form-group">
                <label style="font-weight: 300; color: #B18068" for="email">Enter your registered email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button type="submit" class="button solid">Send Reset Link</button>
        </form>
    </div>
</body>
</html>