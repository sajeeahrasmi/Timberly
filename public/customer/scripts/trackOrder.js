let urlParams ;
let orderId ;
let itemId ;
let userId ;

document.addEventListener("DOMContentLoaded", async () => {
    urlParams = new URLSearchParams(window.location.search);
    orderId = urlParams.get('orderId');
    itemId = urlParams.get('itemId');
    userId = urlParams.get('userId');

    // Validate parameters
    if (!orderId || !itemId || !userId) {
        alert("Invalid order details.");
        return;
    }

    
    try {
        const response = await fetch(`../../config/customer/fetchRawMaterialDetails.php?action=fetchDetails&orderId=${orderId}&itemId=${itemId}&userId=${userId}`);
        const data = await response.json();

        if (data.success) {
           
            document.getElementById("wood-type").textContent = data.lumber.type;
            document.getElementById("dimensions").textContent = "Length "+data.lumber.length + " m, Width: "+ data.lumber.width + " mm, Thickness: " + data.lumber.thickness + " mm";
            document.getElementById("quantity").textContent = data.itemDetail.qty;
            document.getElementById("price").textContent = " Rs. " + data.lumber.unitPrice;
            document.getElementById("item-status").textContent = data.itemDetail.status;
            
            updateButtonsBasedOnStatus("Delivered");
        } else {
            alert("Failed to fetch order details.");
        }
    } catch (error) {
        console.error("Error fetching order details:", error);
        alert("An error occurred.");
    }
});


function updateButtonsBasedOnStatus(status) {

    if(status == "Pending"){
        document.getElementById("edit-btn").disabled = false;
        document.getElementById("view-location-btn").disabled = true;
        document.getElementById("leave-review-btn").disabled = true;
    }else if (status == "Delivering"){
        document.getElementById("edit-btn").disabled = true;
        document.getElementById("view-location-btn").disabled = false;
        document.getElementById("leave-review-btn").disabled = true;
    }else if (status == "Delivered"){
        document.getElementById("edit-btn").disabled = true;
        document.getElementById("view-location-btn").disabled = true;
        document.getElementById("leave-review-btn").disabled = false;
    }else{
        document.getElementById("edit-btn").disabled = true;
        document.getElementById("view-location-btn").disabled = true;
        document.getElementById("leave-review-btn").disabled = true;
    }
}


//////////////////////////////////
// Get all the buttons and popups
const editBtn = document.getElementById('edit-btn');
const viewLocationBtn = document.getElementById('view-location-btn');
const leaveReviewBtn = document.getElementById('leave-review-btn');

const editPopup = document.getElementById('edit-popup');
const deliveryPopup = document.getElementById('delivery-popup');
const reviewPopup = document.getElementById('review-popup');

// Enable buttons when data is loaded
window.addEventListener('DOMContentLoaded', () => {
    // Enable buttons (in a real app, you might want to check certain conditions first)
    editBtn.disabled = false;
    viewLocationBtn.disabled = false;
    leaveReviewBtn.disabled = false;

    // Add click event listeners
    editBtn.addEventListener('click', () => openPopup('edit-popup'));
    viewLocationBtn.addEventListener('click', () => openPopup('delivery-popup'));
    leaveReviewBtn.addEventListener('click', () => openPopup('review-popup'));
});

// Function to open popup
function openPopup(popupId) {
    const popup = document.getElementById(popupId);
    popup.style.display = 'block';
    
    // Close popup when clicking outside
    popup.addEventListener('click', (e) => {
        if (e.target === popup) {
            closePopup(popupId);
        }
    });
}

// Function to close popup
function closePopup(popupId) {
    const popup = document.getElementById(popupId);
    popup.style.display = 'none';
}

// Handle quantity update
function updateQuantity() {
    const newQty = document.getElementById('new-qty').value;
    if (newQty && newQty > 0) {
        // Update the quantity display
        document.getElementById('quantity').textContent = newQty;
        // Here you would typically make an API call to update the backend
        closePopup('edit-popup');
    } else {
        alert('Please enter a valid quantity');
    }
}

// Handle delivery tracking
function trackLiveLocation() {
    // Placeholder function for tracking delivery
    alert('Tracking feature would be implemented here');
}

// Handle review submission
function submitReview() {
    const reviewText = document.getElementById('review-text').value;
    if (reviewText.trim()) {
        // Here you would typically make an API call to submit the review
        alert('Thank you for your review!');
        closePopup('review-popup');
    } else {
        alert('Please write a review before submitting');
    }
}

// Example function to load delivery details (you would replace this with actual data)
function loadDeliveryDetails() {
    document.getElementById('delivery-name').textContent = 'John Doe';
    document.getElementById('delivery-contact').textContent = '123-456-7890';
    document.getElementById('delivery-vehicle').textContent = 'ABC 123';
    document.getElementById('delivery-date').textContent = '2025-02-15';
}

// Load delivery details when the page loads
window.addEventListener('DOMContentLoaded', loadDeliveryDetails);