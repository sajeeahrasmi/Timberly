<?php
require '../config/db_connection.php';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email = $_GET['email'];
$token = $_GET['token'];

$stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? AND reset_token = ?");
$stmt->execute([$email, $token]);
$user = $stmt->fetch();

if ($user) {
    if (strtotime($user['token_expiry']) >= time()) {
        $stmt = $pdo->prepare("UPDATE user SET reset_token = NULL, token_expiry = NULL WHERE email = ?");
        $stmt->execute([$email]);
        echo "<script>
            alert('Your email has been verified. You can now log in using your credentials given in the mail.');
            window.location.href = 'login.php';
        </script>";
    } else {
        echo "<script>
            alert('Verification link expired.');
            window.location.href = 'landingPage.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid verification link.');
        window.location.href = 'landingPage.php';
    </script>";
}
?>
