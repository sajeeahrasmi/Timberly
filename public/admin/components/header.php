<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly-Admin</title>

    <link rel="stylesheet" href="../styles/components/header.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../scripts/components/header.js" defer></script>
</head>
<body>
    <header class="top-bar">
        <h1>Welcome Admin</h1>
        <div class="user-profile">
            <span onclick="window.location.href='./notifications.php'" style="cursor: pointer;"><i class="fa-regular fa-bell" style="transition: 0.3s;"></i></span>
            <span onclick="window.location.href='./adminProfile.php'" style="display: flex;"><i class="fa-regular fa-user"></i><h5>Admin</h5></span>
        </div>
    </header>
</body>
</html>