document.addEventListener("DOMContentLoaded", () => {
    const status = document.getElementById("item-status").textContent;
    const orderstatus = document.getElementById("item-order-status").textContent;
    const editBtn = document.getElementById("edit-btn");
    const viewLocationBtn = document.getElementById("view-location-btn");
    const leaveReviewBtn = document.getElementById("leave-review-btn");
    const designerButton = document.getElementById("contact-designer-btn");

    const popups = {
                edit: document.getElementById('edit-popup'),
                delivery: document.getElementById('delivery-popup'),
                review: document.getElementById('review-popup')
            };

    function updateButtonsBasedOnStatus(status) {
       
        editBtn.disabled = true;
        viewLocationBtn.disabled = true;
        leaveReviewBtn.disabled = true;
        designerButton.disabled = true;

        if (status === "Pending" ) {
            editBtn.disabled = false;  
            viewLocationBtn.disabled = true;
            leaveReviewBtn.disabled = true;
            designerButton.disabled = true;          
        } else if (status === "Approved" && orderstatus === "Processing") {
            editBtn.disabled = true;  
            viewLocationBtn.disabled = true;
            leaveReviewBtn.disabled = true;
            designerButton.disabled = false;
        } else if (status === "Not_Approved") {
            editBtn.disabled = true;
            viewLocationBtn.disabled = true;
            leaveReviewBtn.disabled = true;
            designerButton.disabled = true;
        }else if (status === "Processing") {
            editBtn.disabled = true;
            viewLocationBtn.disabled = true;
            leaveReviewBtn.disabled = true;
            designerButton.disabled = true;
        }else if (status === "Finished") {
            editBtn.disabled = true;
            viewLocationBtn.disabled = false;
            leaveReviewBtn.disabled = true;
            designerButton.disabled = true;
        }else if (status === "Delivered") {
            editBtn.disabled = true;
            viewLocationBtn.disabled = true;
            leaveReviewBtn.disabled = false;
            designerButton.disabled = true;
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

async function updateItem(itemId, orderId){
    
    const type = document.getElementById("edit-type").value; 
    const length = document.getElementById("edit-length").value;
    const width = document.getElementById("edit-width").value;
    const thickness = document.getElementById("edit-thickness").value; 
    const qty = document.getElementById("edit-qty").value; 
    const details = document.getElementById("edit-details").value; 
   

    if(qty < 0 || qty > 20){
        alert("Quantity should be between 1 and 20");  
        return; 
    }
    if(length < 0 || length > 5){
        alert("Length should be between 1 and 5 m");
        return;   
    }
    if(width < 0 || width > 1500){
        alert("Width should be between 1 and 1500 mm"); 
        return;  
    }
    if(thickness < 0 || thickness > 50){
        alert("Thickness should be between 1 and 50 mm"); 
        return;  
    }

    
    
    try{
        const response = await fetch(`../../config/customer/updateDoorOrder.php?action=updateItem&itemId=${itemId}&orderId=${orderId}&type=${type}&qty=${qty}&length=${length}&width=${width}&thickness=${thickness}&details=${details}`);
        const data = await response.json();

        if(data.success){
            alert("Successfully updated the item");
            // closePopup('edit-popup');
            location.reload();
            
        }else{
            alert("Couldnt update.");
        }
    }catch (error){
            console.log("Error: ", error);
    }
}

async function designer(itemId, orderId , userId){
    location.reload();
    window.location.href = `http://localhost/Timberly/public/customer/contactDesigner.php?itemId=${itemId}&orderId=${orderId}`;
}

async function submitReview(orderId, Id){
    
    const reviewText = document.getElementById('review-text').value;
    if (reviewText.trim()) {

        try{
            
            const response = await fetch(`../../config/customer/updateDoorOrder.php?action=updateReview&orderId=${orderId}&Id=${Id}&reviewText=${encodeURIComponent(reviewText)}`);
            const data = await response.json();

            if(data.success){
                alert('Thank you for your review!');
                closePopup('review-popup');
                location.reload();

            }else{
                alert("Couldnt update review.");
            }   

        }catch (error){
                console.log("Error: ", error);
        }
   
    } else {
        alert('Please write a review before submitting');
        return;
    }
}