<?php
    include '../../api/getEditDriver.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly-Admin</title>
        <link rel="stylesheet" href="./styles/editDriver.css">
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
                        <form id="edit-driver-form" class="edit-driver-form" method="POST" action="../../api/getEditDriver.php?driver_id=<?php echo htmlspecialchars($driver_id); ?>" onsubmit="return validateForm()">
                            <h2 style="margin-left: 15px; margin-bottom: 30px">Edit Driver</h2>
                            <div class="form-group">
                                <label for="name">Driver name</label>
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
                                <label for="name">Vehicle No</label>
                                <input 
                                    type="text" 
                                    id="vehicleNo" 
                                    name="vehicleNo" 
                                    placeholder="XX-XXXX" 
                                    value="<?php echo htmlspecialchars($data['vehicleNo']); ?>"
                                    required 
                                    class="input-field" 
                                    pattern="^[A-Za-z]{2,3}-\d{4}$" 
                                    title="Vehicle number must follow the format. Eg: 'bd-2345' or 'bde-3456'.">
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
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Password"
                                    pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                                    title="Password must be at least 8 characters long and contain at least one letter and one number."
                                    required
                                    class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="re-password">Password</label>
                                <input
                                    type="password"
                                    id="re-password"
                                    name="re-password"
                                    placeholder="Re-Password"
                                    pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                                    title="Password must be at least 8 characters long and contain at least one letter and one number."
                                    required
                                    class="input-field">
                            </div>
                            <div class="form-buttons button-container">
                                <button onclick="window.location.href='./drivers.php'" class="button outline">Cancel</button>
                                <button type="submit" class="button solid">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script> src="./scripts/editDriver.js"</script>
</html>
