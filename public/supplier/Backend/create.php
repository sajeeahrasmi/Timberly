<?php
include 'db.php'; // Ensure this file contains a working database connection.
session_start();

if (isset($_POST['submit'])) {
    // Collect form data
    $category = $_POST['category'];
    $type = $_POST['type'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $info = $_POST['info'];


    // Check for empty fields
    if (empty($category) || empty($type) || empty($length) || empty($width) || empty($height) || empty($quantity) || empty($price)) {
        die("All fields are required.");
    }

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Ensure uploads directory exists and is writable
    if (!is_dir('uploads/')) {
        mkdir('uploads', 0777, true);  // Create uploads directory if not exists
    }

    if (!is_writable('uploads/')) {
        die("Uploads directory is not writable.");
    }

    // Move the uploaded file
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        die("Failed to upload image.");
    }

    // Insert data into the database
    $sql = "INSERT INTO `crudpost` (`category`, `type`, `length`, `width`, `height`, `quantity`, `price`, `info`, `image`, `supplierId`) 
            VALUES ('$category', '$type', '$length', '$width', '$height', '$quantity', '$price', '$info', '$image', '{$_SESSION['userId']}')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        // Redirect to display page after successful insertion
        header("Location: display.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
<!-- This is a test comment -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="../styles/globals.css">
    <link rel="stylesheet" href="../styles/layout.css">
    <!-- <link rel="stylesheet" href="../Update Post/style.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        


.body-content-container .body-content{
    display: grid;
    flex-direction: row;
    padding: 10px;
    gap: 10px;
    height:95%;
    margin: 0px;
    background-color: var(--color-white);
    border-radius: 40px;
    box-shadow: var(--box-shadow);

}


.header-content .welcome{
    color: var(--color-primary);
  }

  .popup .popup-content{
    border: 1px solid var(--color-secondary);
    background-color: var(--color-white);
    border-radius: 20px;
    

  }

  .popup .popup-content .pop1{
    box-shadow: var(--box-shadow);
    display: flex;
    justify-content: space-between;
    padding: 12px 10px;
    font-size: 16px;
    margin-bottom: 10px ;
  }

  .popup .popup-content .pop2{
    box-shadow: var(--box-shadow);
    display: flex;
    justify-content: space-between;
    padding: 12px 10px;
    font-size: 16px;
    margin-bottom: 10px ;
  }

  .popup .popup-content .pop3{
    box-shadow: var(--box-shadow);
    display: flex;
    justify-content: space-between;
    padding: 12px 10px;
    font-size: 16px;

  }

  .popup-content .notification-timestamp{
    font-size: 12px;
  }

.body-content .left{
    flex: 2; 
    border-width: 5px;
    border-color: #000000;
    min-height: 300px; 
    /* box-shadow: var(--box-shadow); */
    display: flex;
    flex-direction: column;
    padding: 0px 20px;
    width: 100%;
}

.body-content .left .buttons {
    padding: 0px;
    margin: 0px;
     button {
        background-color: transparent;
        color: #000;
        padding: 10px 20px;
        border-right: 3px solid var(--color-primary); 
        cursor: pointer; 
        font-size: 12px; 
        transition: border-color 0.3s ease;
    }
    
    button:hover {
        border-right-color: var(--color-secondary); 
        background-color: #ccd0d5;
    }
}

.body-content-container .body-content h1{
    font-size: 24px;
    color: var(--color-primary);
    margin: 0px;
    padding: 0px;
    font-family: 'Arial', sans-serif;
    margin-bottom: 10px;
    margin: 0px 0px 10px 0px;
    padding: 0px;
}

.body-content .left .form-content{
    background-color:var(--color-white);
     /* border: 1px solid var(--color-secondary); */
    padding: 30px; 
    border-radius: 10px;
    font-size: 32px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    margin: 10px ;
    height: 100%;
    overflow-y: auto;

    h4{
        text-align: left;
        font-family: 'Arial', sans-serif;
        color: var(--color-primary);
        margin-bottom: 10px;
        margin: 0px 0px 10px 0px;
        padding: 0px;
        
    }

    .add-button{
        display: flex;
        justify-content: flex-end;
        font-size: 14px;

        button{
            padding: 8px 15px;
        }
    }
}

.body-content .left .form-content .form-group{
    box-shadow: var(--box-shadow);
    border-radius: 10px;
    padding: 0;
    margin-top: 0;
    margin-bottom: 10px;
    padding: 5px 0px 5px 5px;

    label{
        font-family: 'Arial', sans-serif;
        font-size: 16px;
        color: var(--color-primary);
        margin-bottom: 5px;
        font-weight: 700;
        margin-right: 10px;
        text-align:end;
        margin-right: 1px;
    }

    h5{
        margin: 5px 0px 0px 0px ;
        padding: 0px;
    }

    input{
        width: 20%;
        margin-right: 15px;
        border-radius: 5px;
        border: 1px solid var(--color-primary);
        font-size: 16px;
    }

    select, input[type="text"], textarea {
        padding: 5px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        background-color: #fff;
        transition: border 0.3s;
        width: 30%;
        height: 30px;
        border: 1px solid var(--color-primary);
        color: var(--color-secondary);

        &&:focus{
            border-color: var(--color-secondary);
        }
    }

    input[type="radio"] {
        width: auto;
        height: auto;
    
        margin: 3px 15px 3px 5px;
        font-size: 16px;
        cursor: pointer;
        color: var(--color-secondary);
        border: 1px solid var(--color-primary);
    }
}


.form-content button{
    padding: 10px 20px;
    background-color: var(--color-primary);
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.3s ease;
    margin-top: 10px;
    font-size: 16px;
}


.form-content button:hover{
    background-color: var(--color-secondary);
    transform: translateY(-2px);
    font-size: 16px;
}



.popup .popup-wrapper .popup-header h3{
    font-size: 24px;
    color: var(--color-primary);
    margin: 0px;
    padding: 0px;
    font-family: 'Arial', sans-serif;
    margin-bottom: 10px;
    margin: 0px 0px 10px 0px;
    padding: 0px;
}


.popup .popup-wrapper.popup-contet button .popup-trigger{
    background-color: var(--color-white);
    border-radius: 10px;
    color: var(--color-primary);
    padding: 20px;
    box-shadow: var(--box-shadow);
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    height: 100%;
    overflow-y: auto;
}
    </style>
</head>
<body>
<header>
    <div class="header-content">
        <div class="header-logo">Timberly</div>
        <div class="welcome"> <h3>Welcome <?php echo $_SESSION['name']; ?></h3></div>
        <nav class="header-nav">
            <button data-popup-id="notification-popup" class="header-link popup-trigger"><i
                    class="fa-solid fa-bell"></i></button>
            <a href="../Update Profile/updateprofile.html" class="header-link"><i class="fa-solid fa-user"></i></a>
        </nav>
    </div>


    <div class="popup" id="notification-popup">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Notifications</h3>
                <button class="popup-close-button" style="color:var(--color-primary)"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
                <button class="popup-trigger" data-popup-id="not-1">
                    <div class="pop1">
                    <div class="notification-message">Order Payment paid successfully!</div>
                    <div class="notification-timestamp">2024-11-25 02:15 PM</div> 
                    </div>
                 
                </button>

                <button class="popup-trigger" data-popup-id="not-2">
                    <div class="pop2">
                    <div class="notification-message">Your post has been approved!</div>
                    <div class="notification-timestamp">2024-11-27 10:30 AM</div>
                    </div>
                </button>

                <button class="popup-trigger" data-popup-id="not-3">
                    <div class="pop3">
                    <div class="notification-message">Timber stock is running low!</div>
                    <div class="notification-timestamp">2024-11-27 10:30 AM</div>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <div class="popup" id="not-1">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Order Payment paid successfully!</h3>
                <button class="popup-close-button" style="color:var(--color-primary)"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
            The message "Order Payment Paid Successfully!" serves as a confirmation to both the supplier and the woodworking company 
            that the payment for an order has been processed without any issues. This notification is essential in maintaining 
            transparency and trust between the supplier and the buyer, ensuring the transaction is complete and ready for the next 
            steps, such as delivery or invoicing.
            </div>
        </div>
    </div>
    <div class="popup" id="not-2">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Your post has been approved!</h3>
                <button class="popup-close-button"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
            This notification confirms that the post you submitted has successfully passed the review process and is now live or 
            visible to others. It reassures you that your content meets the necessary guidelines and encourages further engagement.
            </div>
        </div>
    </div>
    <div class="popup" id="not-3">
        <div class="popup-wrapper">
            <div class="popup-header">
                <h3 class="popup-title" style="color:var(--color-primary)">Timber stock is running low!</h3>
                <button class="popup-close-button" style="color:var(--color-primary)"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="popup-content">
            This notification alerts you that the stock of a specific type of timber is nearing depletion. It serves as a reminder 
            to restock promptly to avoid delays in fulfilling orders or disruptions in production.
            </div>
        </div>
    </div> 
</header>

<div class="body-content-wrapper">
    <div class="sidebar">
        <div class="sidebar-content">
                <a href="../Dashboard/dashboard.html" class="sidebar-link"><i class="fa-solid fa-house icon"></i>Dashboard</a>
                <a href="../Backend/create.php" class="sidebar-link active"><i class="fa-solid fa-plus"></i>Create Post</a>
                <a href="../Backend/display.php" class="sidebar-link"><i class="fa-solid fa-box"></i>Supplier Posts</a>
                <a href="../Posts/approved.html" class="sidebar-link"><i class="fa-solid fa-bag-shopping"></i>Supplier Orders</a>
                <a href="../Update Profile/updateprofile.html" class="sidebar-link"><i class="fas fa-user"></i>User Profile</a>
                <a href="http://localhost/Timberly/config/logout.php" class="sidebar-link"><i class="fa-solid fa-right-from-bracket icon"></i>Log Out</a>
        </div>
    </div>

    <div class="body-content-container">
        <div class="body-content">
            <div class="left">
            <div class="form-content">
                <h1>Create Post Details</h1>
                <form action="create.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="category">Select Category:</label>
                        <select id="category" name="category" required>
                            <option value="Timber">Timber</option>
                            <option value="Lumber">Lumber</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Select Type:</label>
                        <select id="type" name="type" required>
                            <option value="Jak">Jak</option>
                            <option value="Teak">Teak</option>
                            <option value="Mahogani">Mahogani</option>
                            <option value="Cinamond">Cinamond</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="length">Length(m):</label>
                        <input type="number" name="length" placeholder="Enter the length" required min="0">

                        <label for="width">Width(mm):</label>
                        <input type="number" name="width" placeholder="Enter the width" required min="0">

                        <label for="height">Height(mm):</label>
                        <input type="number" name="height" placeholder="Enter the height" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" placeholder="Enter the quantity" required min="1">

                        <label for="price">Price per Unit:</label>
                        <input type="number" name="price" placeholder="Enter the price per unit" required min="1">
                    </div>

                    <div class="form-group">
                        <label for="info">Additional Information:</label><br>
                        <textarea name="info" placeholder="Enter additional information" ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="button outline">Add Post</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>

<script src="../scripts/popup.js"></script>
</body>
</html>
