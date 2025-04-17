<?php
session_start();
include '../../config/db_connection.php'; // DB connection

// Get logged-in user ID (fallback to 1 for testing)
// $user_id = $_SESSION['user_id'] ?? 1;

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
} else {
    // error handling: user not logged in
    // e.g., redirect to login page or show message
    header("Location: login.php");
    exit();
}


// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name']; // Corrected variable name to $name to match form input name
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Corrected table and ID column
    $updateQuery = "UPDATE user SET name='$name', email='$email', phone='$phone', address='$address' WHERE userID='$userId'";
    mysqli_query($conn, $updateQuery);
}

// Fetch user data
$query = "SELECT name, email, phone, address FROM user WHERE userID=$userId";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/userProfile.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="user-content">
        <div class="profile">
            <img src="images/profile.png" alt="Profile Image" />
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>

            <div class="profile-info">
                <div class="info-item">
                    <span><i class="fa-solid fa-envelope"></i></span>
                    <h4>Email</h4>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="info-item">
                    <span><i class="fa-solid fa-phone"></i></span>
                    <h4>Contact</h4>
                    <p><?php echo htmlspecialchars($user['phone']); ?></p>
                </div>
                <div class="info-item">
                    <span><i class="fa-solid fa-location-dot"></i></span>
                    <h4>Address</h4>
                    <p><?php echo htmlspecialchars($user['address']); ?></p>
                </div>
            </div>
        </div>

        <div class="edit-profile">
            <h3>Edit Profile</h3>
            <form method="POST" action="">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label>Phone Number</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

                <label>Address</label>
                <textarea name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>

                <button type="submit" class="button-outline">Update & Save</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
