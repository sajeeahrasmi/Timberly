<?php
include '../../config/db_connection.php';
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'supplier') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css">
    <link rel="stylesheet" href="styles/notification.css">
    <title>Notifications</title>
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="body-content" id="main-content">
        <div id="notification-overlay" class="notification-overlay hidden">
            <div class="notification-card">
                <h2> Notifications</h2>
                <ul id="notification-list"></ul>
                <button onclick="closeNotification()">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
function openNotification(posts) {
    const overlay = document.getElementById("notification-overlay");
    const list = document.getElementById("notification-list");
    const mainContent = document.getElementById("main-content");

    list.innerHTML = "";
    posts.forEach(post => {
        const item = document.createElement("li");
        item.textContent = `✅ ${post.type} post with ID ${post.postId} has been approved.`;
        list.appendChild(item);
    });

    overlay.classList.remove("hidden");
    mainContent.classList.add("blurred");
}

function closeNotification() {
    document.getElementById("notification-overlay").classList.add("hidden");
    document.getElementById("main-content").classList.remove("blurred");
    window.location.href = "dashboard.php"; // Redirect to the same page to refresh the notifications
}

document.addEventListener("DOMContentLoaded", () => {
    fetch('../../api/checkApproval.php')
        .then(res => res.json())
        .then(data => {
            if (data.approved && data.posts.length > 0) {
                openNotification(data.posts);
            }
        })
        .catch(err => console.error("Error fetching approval status:", err));
});
</script>

</body>
</html>
