<?php
    include '../../api/db.php';
    $query = "SELECT * FROM user WHERE userId = 5";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error fetching user data: " . mysqli_error($conn));
    }
    $userData = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
    
        if ($password !== $repassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
            exit;
        }
    
        $query1 = "
            UPDATE user 
            SET name = '$name', phone = '$phone', address = '$address', email = '$email'
            WHERE userId = 5;
        ";
    
        $query2 = "
            UPDATE login
            SET password = '$password'
            WHERE userId = 5;
        ";
    
        $result1 = mysqli_query($conn, $query1);
        $result2 = mysqli_query($conn, $query2);
    
        if (!$result1 || !$result2) {
            echo json_encode(['success' => false, 'message' => 'Error updating data: ' . mysqli_error($conn)]);
            exit;
        }
    
        header("Location: adminProfile.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly-Admin</title>
    <link rel="stylesheet" href="./styles/adminProfile.css">
    <link rel="stylesheet" href="./styles/components/header.css">
    <link rel="stylesheet" href="./styles/components/sidebar.css">
</head>
<body>

    <div class="dashboard-container">
        <?php include "./components/sidebar.php" ?>
        <div class="main-content">
            <?php include "./components/header.php" ?>
            <div class="content">
                <div class="profile">

                    <img src="../images/profile.jpg" alt="profile" />
                    <h2><?php echo $userData['name']; ?></h2>

                    <div class="profile-info">
                        <div class="info-item">
                            <span><i class="fa-solid fa-envelope"></i></span>
                            <h4>Email</h4>
                            <p><?php echo $userData['email']; ?></p>
                        </div>
                        <div class="info-item">
                            <span><i class="fa-solid fa-phone"></i></span>
                            <h4>Contact</h4>
                            <p><?php echo $userData['phone']; ?></p>
                        </div>
                        <div class="info-item">
                            <span><i class="fa-solid fa-location-dot"></i></span>
                            <h4>Address</h4>
                            <p><?php echo $userData['address']; ?></p>
                        </div>
                    </div>
                </div>

                <form method="POST" class="edit-profile" onsubmit="return validateForm()">
                    <h3>Edit Profile</h3>
                    <label>Name</label>
                    <input
                        type="text"
                        name="name"
                        pattern="^[A-Za-z\s]+$"
                        title="Name can only contain alphabets and spaces."
                        value="<?php echo htmlspecialchars($userData['name']); ?>"
                        required>

                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        pattern="[a-z0-9._%+-]+@[a-z09.-]+\.[a-z]{2,}$"
                        title="Name can only contain alphabets and spaces."
                        value="<?php echo htmlspecialchars($userData['email']); ?>"
                        required>
            
                    <label>Phone Number</label>
                    <input
                        type="tel"
                        name="phone"
                        pattern="^07\d{8}$"
                        title="Please enter a valid phone number."
                        value="<?php echo htmlspecialchars($userData['phone']); ?>"
                        required>
            
                    <label>Address</label>
                    <input
                        type="text"
                        name="address"
                        placeholder="Enter address"
                        required
                        pattern="^[A-Za-z0-9\s,.-]+$"
                        value="<?php echo htmlspecialchars($userData['address']);?>">

                    <label>Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        required
                        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                        title="Password must be at least 8 characters long and contain at least one letter and one number.">

                    <label>Password Re-enter</label>
                    <input
                        type="password"
                        name="repassword"
                        placeholder="Re-enter password"
                        required
                        pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                        title="Password must be at least 8 characters long and contain at least one letter and one number.">
            
                    <button type="submit" class="button outline">Save</button>
                </form>
            </div>
        </div>
   
    </div>

</body>
</html>
