<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Timberly</title>
    <link rel="stylesheet" href="./styles/login.css">
    </head>
    <body>
        <div class="container">
            <div class="left-side">
                <img src="final_logo.png" alt="Timberly" class="login-logo">
                <h2 style="margin-left: 20px">Sign in</h2>
                <p style="margin-left: 20px">Use your timberly user account</p>
            </div>
        
            <div class="right-side">
                <form id="loginForm" action="../config/login.php" method="POST">
                    <div class="form-group">
                        <input type="text" placeholder="Username" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" placeholder="Password" id="password" name="password" required>
                    </div>
                    
                    <p class="links-to"><a href="forgotPassword.php">Forgot password?</a> | <a href="landingPage.php">Home</a></p>
                    
                    <div class="buttons">
                        <a href="registration.php" class="button outline">Create account</a>
                        <button type="submit" class="button solid">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>