<?php
// Database connection details
$host = "localhost";
$dbname = "Timberly";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize inputs
        $username = htmlspecialchars(trim($_POST['username']));
        $password = $_POST['password'];
        $fullname = htmlspecialchars(trim($_POST['fullname']));
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(trim($_POST['phone']));
        $address = htmlspecialchars(trim($_POST['address']));
        $userType = htmlspecialchars(trim($_POST['user-type']));
        
        // Set status based on user type
        $status = ($userType === 'customer') ? 'Approved' : 'Not Approved';

        // Server-side validation
        $errors = [];

        if (strlen($username) < 4) {
            $errors[] = "Username must be at least 4 characters long";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        if (!preg_match("/^\d{10}$/", $phone)) {
            $errors[] = "Invalid phone number";
        }

        if (empty($errors)) {
            // Check if username or email already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM login l JOIN user u ON l.userId = u.userId WHERE l.username = ? OR u.email = ?");
            $stmt->execute([$username, $email]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                // Username or email exists - show alert and stop execution
                echo "<script>
                    alert('Username or email already exists!');
                    history.back();
                </script>";
                exit();
            } else {
                try {
                    // Begin transaction
                    $pdo->beginTransaction();

                    // First, insert into user table
                    $userStmt = $pdo->prepare("
                        INSERT INTO user (name, address, phone, email, role, status) 
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    
                    $userStmt->execute([
                        $fullname,
                        $address,
                        $phone,
                        $email,
                        $userType,
                        $status
                    ]);

                    // Get the last inserted userId
                    $userId = $pdo->lastInsertId();

                    // Insert into login table
                    $loginStmt = $pdo->prepare("
                        INSERT INTO login (username, password, userId) 
                        VALUES (?, ?, ?)
                    ");
                    
                    $loginStmt->execute([
                        $username,
                        $password,
                        $userId
                    ]);

                    // Commit transaction
                    $pdo->commit();

                    // Different redirections based on user type
                    if ($userType === 'supplier') {
                        echo "<script>
                            alert('Your account is pending approval.');
                            window.location.href = '../public/landingPage.html';
                        </script>";
                    } else {
                        // For customer, direct redirect
                        echo "<script>
                            window.location.href = '../public/landingPage.html';
                        </script>";
                    }
                    exit();
                    
                } catch (PDOException $e) {
                    // Rollback transaction on error
                    $pdo->rollBack();
                    echo "<script>
                        alert('Registration failed: " . str_replace("'", "\\'", $e->getMessage()) . "');
                        history.back();
                    </script>";
                }
            }
        } else {
            // Display validation errors
            $errorMessage = implode("\\n", $errors);
            echo "<script>
                alert('$errorMessage');
                history.back();
            </script>";
        }
    }
} catch(PDOException $e) {
    echo "<script>
        alert('Connection failed: " . str_replace("'", "\\'", $e->getMessage()) . "');
        history.back();
    </script>";
}
?>