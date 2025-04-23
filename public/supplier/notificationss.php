<?php
session_start();
include '../../config/db_connection.php'; // Adjust this path as needed
if (!isset($_SESSION['userId']) || $_SESSION['role'] !== 'supplier') {
    header("Location: ../login.php"); // or wherever your login page is
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Approval Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
            display: none;
        }
        .card h3 {
            margin-bottom: 15px;
            color: green;
        }
        .card p {
            font-size: 16px;
        }
    </style>
</head>
<body>

    <h3>🎉 Post Approved!</h3>
    <p id="approved-post-msg">Checking for updates...</p>
</div>

</div>

<script>
function createCard(postId, type) {
    const card = document.createElement('div');
    card.className = 'card';
    card.style.display = 'block';

    const title = document.createElement('h3');
    title.textContent = '🎉 Post Approved!';

    const message = document.createElement('p');
    message.textContent = `Your ${type} post with ID: ${postId} has been approved.`;

    card.appendChild(title);
    card.appendChild(message);

    return card;
}


function checkApprovalStatus() {
    fetch('check_approval.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('approval-container');
            container.innerHTML = ''; // Clear previous cards

            if (data.approved && data.posts.length > 0) {
                data.posts.forEach(post => {
                    const card = createCard(post.postId, post.type);
                    container.appendChild(card);
                });
            } else {
                const msg = document.createElement('p');
                msg.textContent = "No approved posts yet.";
                msg.style.textAlign = 'center';
                container.appendChild(msg);
            }
        })
        .catch(err => {
            console.error('Polling error:', err);
        });
}

checkApprovalStatus();
setInterval(checkApprovalStatus, 2000);
// check every 10 seconds
</script>

</body>
</html>
