let urlParams ;
let orderId ;
let itemId ;
let userId ;
let length ;
let width ;
let thickness ;
let type ;
let driverId;
let deliveryDate;
let maxQty ;

document.addEventListener("DOMContentLoaded", async () => {
    urlParams = new URLSearchParams(window.location.search);
    orderId = urlParams.get('orderId');
    itemId = urlParams.get('itemId');
    userId = urlParams.get('userId');

    if (!orderId || !itemId || !userId) {
        alert("Invalid order details.");
        return;
    }

    
    try {
        const response = await fetch(`../../config/customer/fetchRawMaterialDetails.php?action=fetchDetails&orderId=${orderId}&itemId=${itemId}&userId=${userId}`);
        const data = await response.json();

        if (data.success) {
           
            document.getElementById("wood-type").textContent = data.lumber.type;
            type = data.lumber.type;
            document.getElementById("dimensions").textContent = "Length "+data.lumber.length + " m, Width: "+ data.lumber.width + " mm, Thickness: " + data.lumber.thickness + " mm";
            length = data.lumber.length;
            width = data.lumber.width;
            thickness = data.lumber.thickness;
            document.getElementById("quantity").textContent = data.itemDetail.qty;
            document.getElementById("price").textContent = " Rs. " + data.lumber.unitPrice;
            document.getElementById("item-status").textContent = data.itemDetail.status;
            driverId = data.itemDetail.driverId;
            
            updateButtonsBasedOnStatus("Delivering");
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

    if (popupId == 'edit-popup'){
        fetchQty();
    }else if (popupId == 'delivery-popup'){
        fetchDeliveryDetail();
    }
    
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

// Handle quantity 
async function fetchQty() {
    const newQty = document.getElementById('newQty');
    if (type && length && width && thickness) {
        try {
            const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}&width=${width}&thickness=${thickness}`);
            const data = await response.json();
            if (data.qtys && data.price) {
                newQty.max = data.qtys;
                maxQty = data.qtys;
            } else {
                qtyLabel.max = 1;
            }
        } catch (error) {
            console.error("Error fetching quantity:", error);
            qtyLabel.textContent = "Qty: Error";
        }
    } else {
        qtyLabel.textContent = "Qty not available";
    }
}

async function updateQuantity(){
    const newQty = document.getElementById('newQty').value;

    if (newQty > maxQty) {
        alert(`Quantity should be less than ${maxQty}`);
    }else{
        try{
            const response = await fetch(`../../config/customer/fetchRawMaterialDetails.php?action=updateQty&orderId=${orderId}&itemId=${itemId}&qty=${newQty}`);
            const data = await response.json();

            if(data.success){
                alert("Successfully updated the quantity");
            }else{
                alert("Couldnt update quantity");
            }
        }catch (error){
                console.log("Error: ", error);
        }
        
    }
}

async function fetchDeliveryDetail(){
    try {
        const response = await fetch(`../../config/customer/fetchRawMaterialDetails.php?action=fetchDriverDetail&driverId=${driverId}`);
        const data = await response.json();

        if (data.success) {
           
            document.getElementById('delivery-name').textContent = data.personalDetail.name;
            document.getElementById('delivery-contact').textContent = data.personalDetail.phone;
            document.getElementById('delivery-vehicle').textContent = data.vehicle;
           
        } else {
            alert("Failed to fetch driver details.");
        }

    } catch (error) {
        console.error("Error fetching driver details:", error);
        alert("An error occurred.");
    }
}



function trackLiveLocation() {
    
    alert('Tracking feature would be implemented here');
}


async function submitReview() {
    const reviewText = document.getElementById('review-text').value;
    if (reviewText.trim()) {

        try{
            const response = await fetch(`../../config/customer/fetchRawMaterialDetails.php?action=updateReview&orderId=${orderId}&itemId=${itemId}&reviewText=${encodeURIComponent(reviewText)}`);
            const data = await response.json();

            if(data.success){
                alert('Thank you for your review!');
                closePopup('review-popup');

            }else{
                alert("Couldnt update review.");
            }   

        }catch (error){
                console.log("Error: ", error);
        }
   
    } else {
        alert('Please write a review before submitting');
    }
}
