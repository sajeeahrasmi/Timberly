<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timberly Sign Up</title>
        <link rel="stylesheet" href="registration.css">
    </head>
<body>
    <div class="container">
    <div class="form-container">
        <div class="logo">
            <img src="final_logo.png" alt="Timberly" style="">
        </div>
        <h2>Create your Timberly Account</h2>
        
        <form id="signupForm" action="../config/registration.php" method="POST" onsubmit="return validateForm()">
            <div class="name-row">
                <div class="form-group half">
                    <input type="text" id="username" name="username" placeholder="Username" pattern="^[a-zA-Z0-9._-]{4,20}$"
                    title="Username must be 4-20 characters long and can include letters, numbers, dots, underscores, or hyphens." required>
                </div>
                <div class="form-group half">
                    <input type="tel" id="phone" name="phone" placeholder="Phone number" pattern="^07\d{8}$"
                    title="Enter a 10-digit phone number starting with 07" required>
                </div>
            </div>
            
            <div class="form-group">
                <input type="text" id="fullname" name="fullname" placeholder="Full name" required pattern="^[a-zA-Z\s]{2,50}$"
                title="Full name should only contain letters and spaces, 2 to 50 characters long" style="margin-bottom: 14px">
                <textarea id="address" name="address" rows="2" placeholder="Address" required style="margin-bottom: 11px"
                  pattern="^[a-zA-Z0-9\s,.-]{5,100}$"
                  title="Address should be 5-100 characters long and can include letters, numbers, spaces, commas, dots, and hyphens."></textarea>
                  <input type="email" id="email" name="email" placeholder="Your email address"
                  pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                  title="Enter a valid email address (e.g., example@domain.com)" required>
                <div class="email-hint">You'll need to confirm that this email belongs to you.</div>
            </div>
            
            <div class="password-row">
                <div class="form-group half">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="error" id="password-error"></span>
                </div>
                <div class="form-group half">
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm" required>
                    <span class="error" id="confirm-password-error"></span>
                </div>
            </div>
            <div class="form-group">
                <select id="user-type" name="user-type" required>
                    <option value="">Select Type</option>
                    <option value="customer">Customer</option>
                    <option value="supplier">Supplier</option>
                </select>
                <span class="error" id="user-type-error"></span>
            </div>
            
            <div class="form-actions">
                <button onclick="window.location.href='login.php'" class="button outline">Sign in instead</button>
                <button type="submit" class="button solid">Next</button>
            </div>
        </form>
    </div>
    
        <div class="image-container">
            <img src="registration-image.jpg" alt="Account Image">
            <div class="image-caption">
                <p style="line-height: 25px;">Crafting Tomorrow's Heirlooms From Nature's Finest Treasures</p>
            </div>
        </div>
    </div>
</body>
</html>