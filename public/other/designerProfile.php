<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];
echo "<script> console.log({$userId})</script>";
echo "<script> console.log('this is user')</script>";

include '../../config/db_connection.php';

$query1 = "SELECT * FROM user WHERE userId = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $userId);
$stmt1->execute();
$result1 = $stmt1->get_result();
$row1 = $result1->fetch_assoc();
$name = $row1['name'] ?? 'Driver';
$address = $row1['address'] ?? '';
$phone = $row1['phone'] ?? '';
$email = $row1['email'] ?? '';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer Profile</title>
    <link rel="stylesheet" href="styles/driverProfile.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="../images/final_logo.png" alt="Logo" style="height: 200px; margin: 0%; padding: 0%;"  />
            </div>
            <h1><?php echo $name; ?>'s Profile</h1>
            <div class="header-buttons">
                <button class="button outline" onclick="window.location.href=`http://localhost/Timberly/public/other/designer.php
                `">Dashboard</button>
                <button class="button solid" onclick="window.location.href=`http://localhost/Timberly/public/landingPage.php`">Logout</button>
            </div>
        </div>

        <div class="profile-container">
            <div class="profile-card view-mode" id="viewProfile">
                <h2>Personal Details</h2>
                <div class="profile-info">
                    <p><strong>Name:</strong> <span><?php echo $name; ?></span></p>
                    <p><strong>Email:</strong> <span><?php echo $email; ?></span></p>
                    <p><strong>Phone:</strong> <span><?php echo $phone; ?></span></p>
                    <p><strong>Address:</strong> <span><?php echo $address; ?></span></p>
                </div>
                <button class="button solid" onclick="showEditMode()">Edit Profile</button>
            </div>

            <div class="profile-card edit-mode" id="editProfile">
                <h2>Edit Profile</h2>
                <form id="profileForm" onsubmit="updateProfile(event)">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required><?php echo $address; ?></textarea>
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="button outline" onclick="cancelEdit()">Cancel</button>
                        <button type="submit" class="button solid">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="scripts/driverProfile.js"></script>
</body>
</html>