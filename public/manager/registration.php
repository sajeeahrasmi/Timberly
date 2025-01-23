<?php
include './includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email, password, createdAt) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php"); 
        exit();
    } else {
        $error = "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Timberly</title>
    <link rel="stylesheet" href="./styles/registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Create your account</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="registration.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <span class="password-hint">Must be at least 8 characters</span>
                </div>

                <button type="submit">Create account</button>
            </form>
            <p class="login-link">Already have an account? <a href="login.php">Sign in</a></p>
        </div>
    </div>
</body>
</html>
