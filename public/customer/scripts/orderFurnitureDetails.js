                            
document.addEventListener('DOMContentLoaded', function() {
    const buttonElement = document.getElementById('action-button');
    const statusElement = document.getElementById('status');
    const buttonAddItem = document.getElementById('addItem');
    const buttonPay = document.getElementById('pay'); 

   
    function updateButton() {
        if (statusElement.textContent === 'Confirmed') {
            buttonPay.disabled = false;
            buttonAddItem.disabled = true;
            buttonElement.style.display = 'none';

        } else if (statusElement.textContent === 'Processing') {
            buttonElement.style.display = 'none';
            buttonAddItem.disabled = true;

        } else {
            buttonPay.disabled = false;
            buttonElement.textContent = 'Cancel Order';
        }
    }

    function paymentDetails(){
        
    }


    // buttonAddItem.onclick = function(){
    //     showPopup();
    // }

    // function showPopup() {
    //     document.getElementById("overlay").style.display = "block";
    //     document.getElementById("popup").style.display = "block";

    //     const selectDesignRadio = document.getElementById('selectDesign');
    //     const inputDesignRadio = document.getElementById('inputDesign');
    //     const designOptionsDiv = document.getElementById('design-options');
    //     const imageInputDiv = document.getElementById('image-input');
    //     const selectedDesign = document.getElementById('selected-design');
    //     const designOptions = document.querySelectorAll('.design-option');
    
    //     // Event listener for radio button change
    //     document.querySelectorAll('input[name="designChoice"]').forEach(radio => {
    //         radio.addEventListener('change', function() {
    //             if (selectDesignRadio.checked) {
    //                 designOptionsDiv.style.display = 'block'; // Show design options
    //                 imageInputDiv.style.display = 'none';    // Hide image input
    //             } else if (inputDesignRadio.checked) {
    //                 imageInputDiv.style.display = 'block';   // Show image input
    //                 designOptionsDiv.style.display = 'none'; // Hide design options
    //             }
    //         });
    //     });
    
    //     // Event listener for selecting a design from the image dropdown
    //     designOptions.forEach(option => {
    //         option.addEventListener('click', function() {
    //             selectedDesign.src = this.src;  // Set the selected design image
    //         });
    //     });


    //     const designImageInput = document.getElementById('design-image');
    //     const imagePreview = document.getElementById('image-preview');

    //     // Listen for changes when the user uploads an image
    //     designImageInput.addEventListener('change', function(event) {
    //         const file = event.target.files[0]; // Get the uploaded file
    //         if (file) {
    //             const reader = new FileReader();  // Create a FileReader to read the file
    //             reader.onload = function(e) {
    //                 imagePreview.src = e.target.result;  // Set the image src to the uploaded file
    //                 imagePreview.style.display = 'block'; // Make the image visible
    //             };
    //             reader.readAsDataURL(file);  // Read the file as a data URL (base64)
    //         }
    //     });        
    //   } 
    
    // updateButton();

    
});


// const popupMessage = document.getElementById('popup-message');
// const overlay = document.getElementById('popup-overlay');
// const closePopupButton = document.getElementById('close-popup');

// closePopupButton.onclick = function(){
//     closePopup();
//   }

//   function closePopup() {
//     document.getElementById("overlay").style.display = "none";
//     document.getElementById("popup").style.display = "none";
//   }

async  function cancelOrder(orderId){
    const confirmation = confirm ("Are you sure you want to cancel this order?");
    if(confirmation){
        try {
            const response = await fetch(`../../config/customer/cancelOrders.php?action=cancelFurniture&orderId=${orderId}`);
            //added
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const text = await response.text(); 
            console.log("Raw response:", text);


            // const result = await response.json();
            const result = JSON.parse(text); 

            if (result.success) {
                alert("Order Cancelled successfully");
                window.location.href = `http://localhost/Timberly/public/customer/orderHistory.php`;
            } else {
                // alert("Failed to cancel the order: " + result.error);
                alert("Failed to cancel the order: " + (result.error || "Unknown error"));
            }

        } catch (error) {
            console.error("Error cancelling the order:", error);
            alert("An error occurred while cancelling the order.");
        }
    }
}

