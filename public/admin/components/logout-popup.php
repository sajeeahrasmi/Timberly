<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly Ltd</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/components/logout-popup.css">
    <script src="../scripts/components/logout-popup.js"></script>
</head>
<body>
    <div class="overlay show"></div>

    <div class="logout-popup show">
        <p class="close-button"> <a href="./index.php"> <i class="fa-solid fa-xmark"></i></a></p>
        <p>Are you sure to log out?</p>
        <div style="margin-top: 40px">
            <a class="cancel-logout" href="./index.php">Cancel</a>
            <a class="proceed-logout" href="../">LogOut</a>
        </div>


    </div>
</body>