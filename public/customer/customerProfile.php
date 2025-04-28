<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];


include '../../config/db_connection.php';

$query = "SELECT * FROM user WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
// $totalorders = $row['totalOrders'] ?? '0';
$name = $row['name'] ?? '';
$email = $row['email'] ?? '';
$address = $row['address'] ?? '';
$phone = $row['phone'] ?? '';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>

    <link rel="stylesheet" href="../customer/styles/customerProfile.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    <script src="../customer/scripts/profile.js" defer></script>


</head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">              
                        
                <div class="profile">

                    <img src="../images/profile.jpg" alt="profile" />
                    <h2><?php echo $name ?></h2>

                    <div class="profile-info">
                        <div class="info-item">
                            <span><i class="fa-solid fa-envelope"></i></span>
                            <h4>Email</h4>
                            <p><?php echo $email ?></p>
                        </div>
                        <div class="info-item">
                            <span><i class="fa-solid fa-phone"></i></span>
                            <h4>Contact</h4>
                            <p><?php echo $phone ?></p>
                        </div>
                        <div class="info-item">
                            <span><i class="fa-solid fa-location-dot"></i></span>
                            <h4>Address</h4>
                            <p><?php echo $address ?></p>
                        </div>
                    </div>
                </div>

                <div class="edit-profile">
                    <h3>Edit Profile</h3>
                    <label>Email</label>
                    <input type="text"  id="email" value="<?php echo $email ?>">
            
                    <label>Phone Number</label>
                    <input type="number"  id="phone" value="<?php echo $phone ?>">
            
                    <label>Address</label>
                    <textarea placeholder="Enter address" id="address"><?php echo $address ?></textarea>
            
                    <button type="submit" class="button outline" onclick="updateProfile(<?php echo $userId ?>)">Save</button>
                </div>
            </div>
        </div>
   
    </div>

</body>
</html>
