<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="stylesheet" href="./styles/addDriver.css">
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
                        <form action="submit.php" method="GET">
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
                                <label for="phone">Tele</label>
                                <input type="tel" id="phone" name="phone" placeholder="(0XX) XX-XXX-XX" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="home_address">Address (Home)</label>
                                <input type="text" id="home_address" name="home_address" placeholder="Home address" required class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="work_address">Address (Work)</label>
                                <input type="text" id="work_address" name="work_address" placeholder="Work address" required class="input-field">
                            </div>
                            <div class="form-buttons button-container">
                                <button type="reset" class="button outline">Cancel</button>
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
