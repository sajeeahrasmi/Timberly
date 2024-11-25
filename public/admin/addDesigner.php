<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="stylesheet" href="./styles/addDesigner.css">
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
                        <form id="add-designer-form" class="add-designer-form" method="POST">
                            <div class="profile-picture">
                                <i class="fa-solid fa-user-tie fa-2xl"></i>
                                <input type="file" id="uploadImage" hidden>
                                <label for="uploadImage" class="button solid">+</label>
                            </div>
                            <div class="form-group">
                                <label for="name">Designer Name</label>
                                <input type="text" id="name" name="name" placeholder="Full name" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="someone@mail.com" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone number</label>
                                <input type="tel" id="phone" name="phone" placeholder="0XXXXXXXXX" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" placeholder="Address" required class="input-field">
                            </div>
                            <div class="form-buttons button-container">
                                <button onclick="window.location.href='./designers.php'" class="button outline">Cancel</button>
                                <button type="submit" class="button solid">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
