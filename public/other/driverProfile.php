<?php
session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.html';</script>";
    exit();
}

$userId = $_SESSION['userId'];

// Database connection
include '../../config/db_connection.php';

// Fetch user details for the profile
$query = "SELECT * FROM user WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>alert('User not found'); window.location.href='../../public/login.html';</script>";
    exit();
}

$name = $user['name'];
$email = $user['email'];
$phone = $user['phone'];
$address = $user['address'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>
    <link rel="stylesheet" href="styles/driverProfile.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="../images/final_logo.png" alt="Logo" style="height: 200px; margin: 0%; padding: 0%;" />
            </div>
            <h1><?php echo $name; ?>'s Profile</h1>
            <div class="header-buttons">
                <button class="button outline" onclick="window.location.href='driver.php'">Dashboard</button>
                <button class="button solid" onclick="window.location.href='../../config/logout.php'">Logout</button>
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
                <form id="profileForm" method="POST" action="updateDriverProfile.php">
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
