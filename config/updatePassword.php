<?php
require 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];

    if (empty($token) || empty($newPassword)) {
        die("Missing token or password");
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Step 1: Get the userId from the token in `user` table
    $stmt = $conn->prepare("SELECT userId FROM user WHERE reset_token=? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $userId = $user['userId'];

        // Step 2: Update the password in the `login` table
        $stmt = $conn->prepare("UPDATE login SET password=? WHERE userId=?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        $stmt->execute();

        // Step 3: Clear the reset token and expiry from `user` table
        $stmt = $conn->prepare("UPDATE user SET reset_token=NULL, token_expiry=NULL WHERE userId=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        echo "Password has been reset successfully.";
    } else {
        echo "Invalid or expired token.";
    }
}
?>