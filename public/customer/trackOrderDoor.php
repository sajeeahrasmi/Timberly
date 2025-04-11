<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Door/Window Track</title>

    <link rel="stylesheet" href="../customer/styles/trackOrderDetails.css">
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
                
                <div class="item-detail">
                    <!-- <div class="item-header"> -->
                        <h2>Order #23</h2>
                        <h3>Item #23</h3>
                    <!-- </div> -->
                    <div class="item-container">
                        <div class="item-image">
                            <img src="../images/bookshelf.jpg" alt="Item Image">
                        </div>
                        <div class="item-info">
                            <p><strong>Description:</strong> Custom wooden door for modern homes.</p>
                            <p><strong>Type of Wood:</strong> Teak</p>
                            <p><strong>Dimensions:</strong> Length: 210 cm, Width: 90 cm, Thickness: 5 cm</p>
                            <p><strong>Quantity:</strong> 2</p>
                            <p><strong>Price:</strong> $450</p>
                            <p><strong>Status:</strong> <span id="item-status" class="status-badge pending">Pending</span></p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button id="edit-btn" class="button outline" disabled>Edit Item</button>
                        <button id="contact-designer-btn" class="button outline" disabled>Contact Designer</button>
                        <button id="view-location-btn" class="button outline" disabled>Delivery Detail</button>
                        <button id="leave-review-btn" class="button outline" disabled>Leave Review</button>
                    </div>
                </div>
                
              
                               
                
                
            </div>
        </div>
   
    </div>

    <div id="overlay" class="overlay" onclick="closePopup()"></div>
    <div id="edit-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Edit Item Details</h2>
            <form>
                <div class="form-group">
                    <label>Wood Type</label>
                    <input type="text" value="Premium Oak">
                </div>
                <div class="form-group">
                    <label>Length</label>
                    <input type="text" value="180 cm">
                </div>
                <!-- Add more form fields as needed -->
            </form>
        </div>
    </div>

    <div id="delivery-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Delivery Information</h2>
            <p><strong>Driver Name:</strong> John Doe</p>
            <p><strong>Vehicle Number:</strong> TRK-5678</p>
            <p><strong>Expected Delivery:</strong> June 15, 2024</p>
            <p><strong>Contact Number:</strong> +1 (555) 123-4567</p>
            <button class="button outline">View Location</button>
        </div>
    </div>

    <div id="review-popup" class="popup">
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h2>Leave a Review</h2>
            <div class="star-rating">
                <span class="star" data-rating="1">★</span>
                <span class="star" data-rating="2">★</span>
                <span class="star" data-rating="3">★</span>
                <span class="star" data-rating="4">★</span>
                <span class="star" data-rating="5">★</span>
            </div>
            <textarea placeholder="Write your review here..." rows="4"></textarea>
            <button class="btn btn-review">Submit Review</button>
        </div>
    </div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const status = document.getElementById("item-status").textContent;
    const editBtn = document.getElementById("edit-btn");
    const contactDesignerBtn = document.getElementById("contact-designer-btn");
    const viewLocationBtn = document.getElementById("view-location-btn");
    const leaveReviewBtn = document.getElementById("leave-review-btn");

    const popups = {
                edit: document.getElementById('edit-popup'),
                delivery: document.getElementById('delivery-popup'),
                review: document.getElementById('review-popup')
            };

    function updateButtonsBasedOnStatus(status) {
        // Reset buttons
        editBtn.disabled = true;
        contactDesignerBtn.disabled = true;
        viewLocationBtn.disabled = true;
        leaveReviewBtn.disabled = true;

        if (status === "Pending" || status === "Confirmed") {
            editBtn.disabled = false;
            if (status === "Confirmed") {
                contactDesignerBtn.disabled = false;
            }
        } else if (status === "Delivering") {
            viewLocationBtn.disabled = false;
        } else if (status === "Completed") {
            leaveReviewBtn.disabled = false;
        }
    }

    // Update buttons on page load
    updateButtonsBasedOnStatus(status);

    editBtn.addEventListener('click', () => openPopup(popups.edit));
    // Example: Navigate to designer page
    contactDesignerBtn.addEventListener("click", () => {
        window.location.href = "../customer/designerPage.html";
    });

    // Example: Handle location view
    viewLocationBtn.addEventListener('click', () => openPopup(popups.delivery));

    // Example: Handle review
    leaveReviewBtn.addEventListener('click', () => openPopup(popups.review));

    function closePopup(popup) {
                popup.style.display = 'none';
                document.getElementById("overlay").style.display = "none";
            }

            // Open popup function
            function openPopup(popup) {
                document.getElementById("overlay").style.display = "block";
                popup.style.display = 'flex';
            }

            // Add close event to all popups
            document.querySelectorAll('.popup-close').forEach(closeBtn => {
                closeBtn.addEventListener('click', (e) => {
                    closePopup(e.target.closest('.popup'));
                });
            });
});

        

         

</script>
</html>
