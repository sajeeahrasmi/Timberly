<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Popup</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Basic Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
    }

    /* Profile Button */
    .unique-profile-btn {
      font-size: 24px;
      padding: 10px;
      cursor: pointer;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .unique-profile-btn:hover {
      background-color: #45a049;
    }

    /* Modal Overlay */
    .unique-modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: none; /* Initially hidden */
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    /* Modal Content */
    .unique-modal-content {
      width: 300px;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .unique-modal-content input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .unique-modal-content button {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    .unique-modal-content button:hover {
      background-color: #45a049;
    }

    .unique-modal-content h3 {
      margin-bottom: 20px;
      font-size: 18px;
    }

    /* Close Button */
    .unique-close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 20px;
      background: none;
      border: none;
      color: #333;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <!-- Profile Button -->
  <button class="unique-profile-btn" onclick="openModal()"><i class="fas fa-user"></i></button>

  <!-- Modal Overlay -->
  <div id="unique-modal-overlay" class="unique-modal-overlay">
    <div class="unique-modal-content">
      <button class="unique-close-btn" onclick="closeModal()">×</button>
      <h3>Manager Profile</h3>
      <form id="unique-profile-form">
        <input type="text" id="unique-name" placeholder="Name" value="John Doe" required>
        <input type="email" id="unique-email" placeholder="Email" value="john.doe@example.com" required>
        <input type="password" id="unique-new-password" placeholder="New Password" required>
        <input type="password" id="unique-confirm-password" placeholder="Confirm New Password" required>
        <button type="submit">Save Changes</button>
      </form>
    </div>
  </div>

  <script>
    // Open the modal
    function openModal() {
      document.getElementById('unique-modal-overlay').style.display = 'flex';
    }

    // Close the modal
    function closeModal() {
      document.getElementById('unique-modal-overlay').style.display = 'none';
    }

    // Handle form submission (validation can be added)
    document.getElementById('unique-profile-form').addEventListener('submit', function (e) {
      e.preventDefault();

      const newPassword = document.getElementById('unique-new-password').value;
      const confirmPassword = document.getElementById('unique-confirm-password').value;

      if (newPassword !== confirmPassword) {
        alert("New password and confirm password do not match.");
      } else {
        alert("Password changed successfully!");
      }
    });
  </script>
</body>
</html>
