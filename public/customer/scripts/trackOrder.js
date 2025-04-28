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


document.addEventListener("DOMContentLoaded", () => {
    const status = document.getElementById("item-status").textContent;
    const editBtn = document.getElementById("edit-btn");
    const viewLocationBtn = document.getElementById("view-location-btn");
    const leaveReviewBtn = document.getElementById("leave-review-btn");

    const popups = {
                edit: document.getElementById('edit-popup'),
                delivery: document.getElementById('delivery-popup'),
                review: document.getElementById('review-popup')
            };

    function updateButtonsBasedOnStatus(status) {
    //    status = 'Delivered'
        editBtn.disabled = true;
        viewLocationBtn.disabled = true;
        leaveReviewBtn.disabled = true;

        if (status === "Pending" ) {
            editBtn.disabled = false;           
        }else if (status === "Approved") {
            editBtn.disabled = true;
        } else if (status === "Finished") {
            viewLocationBtn.disabled = false;
        } else if (status === "Delivered") {
            leaveReviewBtn.disabled = false;
        }
    }

   updateButtonsBasedOnStatus(status);

    editBtn.addEventListener('click', () => openPopup(popups.edit));

    viewLocationBtn.addEventListener('click', () => openPopup(popups.delivery));

   leaveReviewBtn.addEventListener('click', () => openPopup(popups.review));

    function closePopup(popup) {
                popup.style.display = 'none';
                document.getElementById("overlay").style.display = "none";
            }

            function openPopup(popup) {
                document.getElementById("overlay").style.display = "block";
                popup.style.display = 'flex';
            }

            document.querySelectorAll('.popup-close').forEach(closeBtn => {
                closeBtn.addEventListener('click', (e) => {
                    closePopup(e.target.closest('.popup'));
                });
            });
});


async function updateQuantity(orderId, itemId, maxQty){
    const newQty = document.getElementById('edit-qty').value;

    if(newQty < 1){
        alert("Quantity should be greater than 0");
        return;
    }

    if (newQty > maxQty) {
        alert(`Quantity should be less than ${maxQty}`);
        return;
    }else{
        try{
            const response = await fetch(`../../config/customer/fetchRawMaterialDetails.php?action=updateQty&orderId=${orderId}&itemId=${itemId}&qty=${newQty}`);
            const data = await response.json();

            if(data.success){
                alert("Successfully updated the quantity");
                location.reload();
            }else{
                alert("Couldnt update quantity");
            }
        }catch (error){
                console.log("Error: ", error);
        }
        
    }
}


async function submitReview(orderId, itemId) {
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




