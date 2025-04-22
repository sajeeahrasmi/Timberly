<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require 'db_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));
    $expires = date("Y-m-d H:i:s", strtotime('+4 hour')); // I put 4h because of however it has made the expiry time lesser than NOW time

    // Update token and expiry in DB
    $stmt = $conn->prepare("UPDATE user SET reset_token=?, token_expiry=? WHERE email=?");
    $stmt->bind_param("sss", $token, $expires, $email);
    $stmt->execute();

    // Check if user exists
    if ($stmt->affected_rows === 0) {
        echo "<script>
                alert('Email not found.');
                window.location.href='../public/login.php';
            </script>";
        exit;
    }

    $reset_link = "http://localhost/timberly/public/resetPassword.php?token=" . $token;

    // Send mail
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mra802086@gmail.com';  // Your admin email
        $mail->Password = 'jplrhlkqfacsnhkh'; // App password (not Gmail login!)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('mra802086@gmail.com', 'Timberly Admin');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Link';
        $mail->Body    = "Click the link to reset your password: <a href='$reset_link'>$reset_link</a>";

        $mail->send();
        echo "<script>
                alert('Reset link sent! Check your email.');
            </script>";
    } catch (Exception $e) {
        echo "<script>
            alert('Mailer Error: {$mail->ErrorInfo}');
            window.location.href='login.php';
            </script>";
    }
}
?>