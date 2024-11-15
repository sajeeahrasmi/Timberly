<?php
session_start();
include '../../api/db.php'; // include your database connection

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: admin.php"); // redirect to the homepage if logged in
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user details based on email
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: admin.php"); // Redirect to homepage
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        header("Location: registration.php"); // Redirect to registration if user not found
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Timberly</title>
    <link rel="stylesheet" href="./styles/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Login to Timberly</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Sign in</button>
            </form>
            <p class="register">Don't have an account? <a href="registration.php">Sign up</a></p>
        </div>
    </div>
</body>
</html>
