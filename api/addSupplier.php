<?php

include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $mailPassword = $_POST['password'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $token = bin2hex(random_bytes(50));
    $expires = date("Y-m-d H:i:s", strtotime('+4 hour')); // I put 4h because of however it has made the expiry time lesser than NOW time
    
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }
    
    $checkQuery = "SELECT * FROM user WHERE email = '$email' OR phone = '$phone'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or phone already exists.']);
        exit;
    }
    
    $query = "INSERT INTO user (name, address, phone, email, role, status, reset_token, token_expiry, is_verified) 
              VALUES ('$name', '$address', '$phone', '$email', 'supplier', 'Approved', '$token', '$expires', 0)";

    if (mysqli_query($conn, $query)) {
        // Sanitize and trim input
        $name = htmlspecialchars(trim($name));
        $email = htmlspecialchars(trim($email));
        $reset_link = "http://localhost/timberly/public/verifyNewUser.php?email=$email&token=$token";

        $query1 = "INSERT INTO login (username, password, userId) 
                    VALUES ('$username', '$password', LAST_INSERT_ID())";
        if (!mysqli_query($conn, $query1)) {
            echo json_encode(['success' => false, 'message' => 'Error entering login: ' . mysqli_error($conn)]);
            exit;
        }

        // Log the incoming data for debugging
        error_log("Name: $name");
        error_log("Email: $email");

        if (empty($name) || empty($email)) {
            echo "<script>alert('All fields are required.'); window.history.back();</script>";
            exit;
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email address.'); window.history.back();</script>";
            exit;
        }
    
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mra802086@gmail.com';         // your Gmail
            $mail->Password   = 'jplrhlkqfacsnhkh';           // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
    
            // Set From and To
            $mail->setFrom('mra802086@gmail.com', 'Timberly Customer Service');
            $mail->addAddress($email);           // Your receiving email
            $mail->addReplyTo($email, $name);                 // User reply-to
    
            // Email content
            $mail->Subject = "New Contact Message from $name";
            $mail->Body    = "Name: $name\nEmail: $email\n\n
            Message:\nThank you for requesting the registration with Timberly. Your account is successfully created. Now you can edit credentials of your account once you log into the account, by using the link provided.\n\n
            $reset_link\n\nInitial username -> $username\nUse password -> $mailPassword\n";  
    
            // Send the email
            $mail->send();
            echo "<script>alert('Email sent to the supplier successfully!');
                window.history.back();</script>";
        } catch (Exception $e) {
            echo "<script>alert('Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
        }
    }

    header("Location: ../public/admin/suppliers.php");
} else {
    echo json_encode(['success' => false, 'message' => 'Error creating supplier: ' . mysqli_error($conn)]);
}
?>