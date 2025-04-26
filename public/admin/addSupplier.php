<?php
    include '../../api/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="stylesheet" href="./styles/addSupplier.css">
        <link rel="stylesheet" href="./styles/components/header.css">
        <link rel="stylesheet" href="./styles/components/sidebar.css">
    </head>
    <body>
        <div class="dashboard-container">
            <div style="position: fixed">
                <?php include "./components/sidebar.php" ?>
            </div>
            <div class="page-content" style="margin-left: 300px">
                <?php include "./components/header.php" ?>
                <div class="main-content">
                    <div class="card">
                        <form id="add-supplier-form" class="add-supplier-form" method="POST" action="../../api/addSupplier.php" onsubmit="return validateForm()">
                            <div class="profile-picture">
                                <i class="fa-solid fa-user-tie fa-2xl"></i>
                                <input type="file" id="uploadImage" hidden>
                                <label for="uploadImage" class="button solid">+</label>
                            </div>
                            <div class="form-group">
                                <label for="name">Supplier Name</label>
                                <input type="text" 
                                    id="name" 
                                    name="name" 
                                    placeholder="Full name" 
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
                                    required 
                                    class="input-field">
                            </div>
                            <div class="form-buttons button-container">
                                <button onclick="window.location.href='./suppliers.php'" class="button outline">Cancel</button>
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
