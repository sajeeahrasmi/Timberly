<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    
    <!-- Correct relative paths from this file location (e.g., /public/supplier/) -->
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/userProfile.css">
</head>
<body>

<!-- Header -->
<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<!-- Body Container -->
<div class="body-container">

    <!-- Sidebar -->
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="user-content">

        <!-- Profile Section -->
        <div class="profile">
            <img src="images/profile.png" alt="Profile Image" />
            <h2>Limal</h2>

            <div class="profile-info">
                <div class="info-item">
                    <span><i class="fa-solid fa-envelope"></i></span>
                    <h4>Email</h4>
                    <p>limal@gmail.com</p>
                </div>
                <div class="info-item">
                    <span><i class="fa-solid fa-phone"></i></span>
                    <h4>Contact</h4>
                    <p>+947112345678</p>
                </div>
                <div class="info-item">
                    <span><i class="fa-solid fa-location-dot"></i></span>
                    <h4>Address</h4>
                    <p>Reid Avenue, Colombo 7</p>
                </div>
            </div>
        </div>

        <!-- Edit Profile Section -->
        <div class="edit-profile">
            <h3>Edit Profile</h3>

            <form method="POST" action="#">
                <label>Email</label>
                <input type="email" name="email" placeholder="limal@gmail.com" required>

                <label>Phone Number</label>
                <input type="tel" name="phone" placeholder="+947112345678" required>

                <label>Address</label>
                <textarea name="address" placeholder="Reid Avenue, Colombo 7" required></textarea>

                <button type="submit" class="button-outline">Update & Save</button>
            </form>
        </div>

    </div> 

</div> 

</body>
</html>
