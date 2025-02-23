
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
       
        editBtn.disabled = true;
        viewLocationBtn.disabled = true;
        leaveReviewBtn.disabled = true;

        if (status === "Pending" || status === "Approved") {
            editBtn.disabled = false;
            
        } else if (status === "Not_Delivered") {
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

async function updateItem(Id){
    const type = document.getElementById("edit-type").value; 
    const size = document.getElementById("edit-size").value; 
    const qty = document.getElementById("edit-qty").value; 
    const details = document.getElementById("edit-details").value; 
   

    if(qty < 0 || qty > 20){
        alert("Quantity should be between 0 and 20");
        
    }

    console.log(type + " "+ size+" "+qty+ " "+ details+ " "+Id)
    
    try{
        const response = await fetch(`../../config/customer/updateFurnitureOrder.php?action=updateItem&Id=${Id}&type=${type}&qty=${qty}&size=${size}&details=${details}`);
        const data = await response.json();

        if(data.success){
            alert("Successfully updated the item");
            
        }else{
            alert("Couldnt update.");
        }
    }catch (error){
            console.log("Error: ", error);
    }
}

async function submitReview(orderId, Id){
    const reviewText = document.getElementById('review-text').value;
    if (reviewText.trim()) {

        try{
            const response = await fetch(`../../config/customer/updateFurnitureOrder.php?action=updateReview&orderId=${orderId}&Id=${Id}&reviewText=${encodeURIComponent(reviewText)}`);
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