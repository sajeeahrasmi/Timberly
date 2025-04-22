

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <form id="loginForm" action="../config/login.php" method="POST">
            <h2>Login</h2>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group buttons">
                <button type="submit" class="button solid">Login</button>
                <a href="registration.php" class="button outline">Sign Up</a>
            </div>
            <p class="links-to"><a href="forgotPassword.php">Forgot password?</a> | <a href="landingPage.php">Let's ride Home</a></p>
        </form>
    </div>
</body>
</html>