<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="stylesheet" href="./styles/editDriver.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <?php include "./components/sidebar.php" ?>
            <div class="page-content">
                <?php include "./components/header.php" ?>
                <div class="main-content">
                    <div class="card">
                        <form id="add-driver-form" class="add-driver-form" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="profile-picture">
                                <i class="fa-solid fa-user-tie fa-2xl"></i>
                                <input type="file" id="uploadImage" hidden>
                                <label for="uploadImage" class="button solid">+</label>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" placeholder="Full name" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="someone@mail.com" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone number</label>
                                <input type="tel" id="phone" name="phone" placeholder="(0XX) XX-XXX-XX" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" placeholder="Address" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="nic">NIC</label>
                                <input type="text" id="nic" name="nic" placeholder="NIC" required class="input-field">
                            </div>
                            <div class="form-buttons button-container">
                                <button onclick="window.location.href='./editDriver.php'" class="button outline">Cancel</button>
                                <button type="submit" class="button solid">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="./scripts/addDriver.js"></script>
    </body>
</html>