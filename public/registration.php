<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div class="container">
        <form id="signupForm" action="../config/registration.php" method="POST" onsubmit="return validateForm()">
            <h2>Create Account</h2>
            
            <div class="form-group">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" required>
                <span class="error" id="username-error"></span>
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
                <span class="error" id="password-error"></span>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password *</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <span class="error" id="confirm-password-error"></span>
            </div>

            <div class="form-group">
                <label for="fullname">Full Name *</label>
                <input type="text" id="fullname" name="fullname" required>
                <span class="error" id="fullname-error"></span>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
                <span class="error" id="email-error"></span>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <input type="tel" id="phone" name="phone" required>
                <span class="error" id="phone-error"></span>
            </div>

            <div class="form-group">
                <label for="address">Address *</label>
                <textarea id="address" name="address" required></textarea>
                <span class="error" id="address-error"></span>
            </div>

            <div class="form-group">
                <label for="user-type">Account Type *</label>
                <select id="user-type" name="user-type" required>
                    <option value="">Select Type</option>
                    <option value="customer">customer</option>
                    <option value="supplier">supplier</option>
                </select>
                <span class="error" id="user-type-error"></span>
            </div>

            <div class="form-group">
                <button type="submit" class="button solid">Sign Up</button>
                <button type="reset" class="button outline">Reset</button>
            </div>
        </form>
    </div>
</body>
<script src="registration.js"></script>
</html>