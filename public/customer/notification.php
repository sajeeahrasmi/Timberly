<?php

session_start();

if (!isset($_SESSION['userId'])) {
    echo "<script>alert('Session expired. Please log in again.'); window.location.href='../../public/login.php';</script>";
    exit();
}

$userId = $_SESSION['userId'];

include '../../config/db_connection.php';

$queryCat = "SELECT * FROM customernotification WHERE userId = ? AND view = 'no'";
$stmtCat = $conn->prepare($queryCat);
$stmtCat->bind_param("i", $userId);
$stmtCat->execute();
$resultCat = $stmtCat->get_result();
$notifications = [];
while ($row = $resultCat->fetch_assoc()) {
    $notifications[] = $row;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Raw Material Order</title>

    <link rel="stylesheet" href="../customer/styles//notification.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <script src="../customer/scripts/sidebar.js" defer></script>
    <script src="../customer/scripts/header.js" defer></script>
    

    

</head>
<body>

    <div class="dashboard-container">
        <div id="sidebar"></div>

        <div class="main-content">
            <div id="header"></div>

            <div class="content">
                <div class="notifications">
                    <h2>Notifications</h2>
                    <div class="notification-list">
                    
                    <?php foreach ($notifications as $note): ?>
                    <div class="notification" data-id="<?= $note['notificationId'] ?>">
                        <div class="notification-content">
                            <p><strong>From:</strong> <?= htmlspecialchars($note['fromWhom']) ?></p>
                            <p><strong>Message:</strong> <?= htmlspecialchars($note['message']) ?></p>
                        </div>
                        <?php if ($note['view'] === 'no'): ?>
                            <button class="button outline mark-read">Mark as Read</button>
                        <?php else: ?>
                            <button class="button solid" disabled>Read</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                    
                    
                    
                    </div>
                </div>
            </div>
            
        </div>
            
    </div>

</body>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.mark-read').forEach(button => {
        button.addEventListener('click', function () {
            this.textContent = 'Read';
            this.classList.remove('outline');
            this.classList.add('solid');
            this.disabled = true;
            const parent = this.closest('.notification');
            const notificationId = parent.getAttribute('data-id');
            try{
                const response =  fetch(`../../config/customer/notification.php?action=updateview&notificationId=${notificationId}`);
                const data =  response.json();
                if(data.success){
                    this.textContent = 'Read';
                    this.classList.remove('outline');
                    this.classList.add('solid');
                    this.disabled = true;
            }else{
                alert("Couldnt mark as read.");
            }   
        }catch (error){
                console.log("Error: ", error);
        }
        });
    });
});            
</script>

</html>
