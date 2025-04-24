<?php
    include '../..api/auth.php';
    include '../../api/getEditCustomer.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="stylesheet" href="./styles/editCustomer.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <div style="position: fixed">
                <?php include "./components/sidebar.php" ?> 
            </div>
            <div class="main-content" style="margin-left: 300px">
                <?php include "./components/header.php" ?>
                <div class="main-content">
                    <div class="card">
                    <form id="edit-customer-form" class="edit-customer-form" method="POST" enctype="multipart/form-data" action="../../api/getEditCustomer.php?customer_id=<?php echo htmlspecialchars($user_id); ?>" onsubmit="return validateForm()">
                        <h2 style="margin-left: 15px; margin-bottom: 30px">Edit Customer</h2>
                        <div class="form-group">
                            <label for="name">Customer name</label>
                            <input type="text" 
                                id="name" 
                                name="name" 
                                placeholder="Full name"
                                value="<?php echo htmlspecialchars($data['name']); ?>"
                                required 
                                class="input-field" 
                                pattern="^[A-Za-z\s]+$" 
                                title="Name can only contain alphabets and spaces.">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                pattern="[a-z0-9._%+-]+@[a-z09.-]+\.[a-z]{2,}$"
                                placeholder="someone@mail.com"
                                value="<?php echo htmlspecialchars($data['email']); ?>"
                                required 
                                class="input-field">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                placeholder="07XXXXXXXX"
                                value="<?php echo htmlspecialchars($data['phone']); ?>"
                                required 
                                class="input-field" 
                                pattern="^07\d{8}$" 
                                title="Phone number must start with '07' and contain exactly 10 digits.">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input 
                                type="text" 
                                id="address" 
                                name="address" 
                                placeholder="Address"
                                value="<?php echo htmlspecialchars($data['address']); ?>" 
                                required 
                                class="input-field">
                        </div>
                        <div class="form-buttons button-container">
                            <button onclick="window.location.href='./customers.php'" class="button outline">Cancel</button>
                            <button type="submit" class="button solid">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('uploadImage').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('previewImage');
                const icon = document.getElementById('defaultIcon');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        icon.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </body>
</html>
