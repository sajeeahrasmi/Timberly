let userId = 0;
let orderId = 0;

document.addEventListener("DOMContentLoaded", () => {
  fetch("../../config/customer/customer.php")
  .then(response => {
      if (!response.ok) {
          throw new Error("Failed to fetch customer data.");
      }
      return response.json();
  })
  .then(data => {
      userId = data.userId;
      console.log(userId);
      fetchOrderDetails();
  })
  .catch(error => {
      console.error("Error:", error);
      alert("Session expired. Please log in again.");
      window.location.href = "../../public/login.html"
  });
});

async function fetchOrderDetails() {
  try {
      console.log(userId);
      const response = await fetch(`../../config/customer/fetchlastorder.php?userId=${userId}`);
      const data = await response.json();

      if (data.success) {
          const tableBody = document.querySelector("#orderDetails tbody");
          tableBody.innerHTML = ""; // Clear existing rows

          data.items.forEach(item => {
              const row = document.createElement("tr");
              orderId = item.orderId;
              console.log(orderId)

              row.innerHTML = `
                  <td>${item.orderId}</td>
                  <td>${item.itemId}</td>
                  <td>${item.type}</td>
                  <td>${item.length}</td>
                  <td>${item.width}</td>
                  <td>${item.thickness}</td>
                  <td>${item.qty}</td>
                  <td>${item.unitPrice}</td>
                  <td><i class="fa-solid fa-pen pen-icon" data-order-id="${item.orderId}" data-item-id="${item.itemId}" data-qty="${item.qty}"></i></td>
              `;

              tableBody.appendChild(row);
          });

          // Add event listeners to pen icons
          const penIcons = document.querySelectorAll(".pen-icon");
          penIcons.forEach(icon => {
              icon.addEventListener("click", (e) => {
                  const orderId = e.target.getAttribute("data-order-id");
                  const itemId = e.target.getAttribute("data-item-id");
                  const qty = e.target.getAttribute("data-qty");

                  showPopup2(orderId, itemId, qty);
              });
          });
      } else {
          alert("Failed to fetch order details. Please try again.");
      }
  } catch (error) {
      console.error("Error fetching order details:", error);
      alert("An error occurred while fetching order details.");
  }
}


// async function showPopup2(orderId, itemId, currentQty) {
//     document.getElementById("overlay").style.display = "block";
//     const popup = document.getElementById("popup-2");
//     const content = document.getElementById("popup-content");
//     const qtyInput = document.getElementById("qty");

//     try {
//         // Fetch maximum quantity for the itemId from the lumber table
//         const response = await fetch(`../../config/customer/fetchLumberQty.php?itemId=${itemId}`);
//         const data = await response.json();

//         if (data.success) {
//             const maxQty = data.maxQty;

//             // Set popup content
//             content.textContent = `Order ID: ${orderId}, Item ID: ${itemId}`;

//             // Configure quantity input
//             qtyInput.value = currentQty;
//             qtyInput.min = 1;
//             qtyInput.max = maxQty;

//     const saveBtn = document.createElement("button");
//     saveBtn.textContent = "Save";
//     saveBtn.onclick = () => updateQuantity(orderId, itemId, qtyInput.value);

//     popup.appendChild(saveBtn);
//     popup.style.display = "block";

//             // Show popup
//             popup.style.display = "block";
//         } else {
//             alert("Failed to fetch lumber quantity. Please try again.");
//         }
//     } catch (error) {
//         console.error("Error fetching lumber quantity:", error);
//         alert("An error occurred while fetching lumber details.");
//     }
// }

async function showPopup2(orderId, itemId, currentQty) {
    document.getElementById("overlay").style.display = "block";
    const popup = document.getElementById("popup-2");
    const content = document.getElementById("popup-content");
    const qtyInput = document.getElementById("qty");

    try {
        // Fetch maximum quantity for the itemId from the lumber table
        const response = await fetch(`../../config/customer/fetchLumberQty.php?itemId=${itemId}`);
        const data = await response.json();

        if (data.success) {
            const maxQty = data.maxQty;

            // Set popup content
            content.textContent = `Order ID: ${orderId}, Item ID: ${itemId}`;

            // Configure quantity input
            qtyInput.value = currentQty;
            qtyInput.min = 1;
            qtyInput.max = maxQty;

            // Clear existing buttons and add styled ones
            const buttonContainer = document.createElement("div");
            buttonContainer.classList.add("button-container");

            const saveBtn = document.createElement("button");
            saveBtn.textContent = "Save";
            saveBtn.className = "button solid"; // Styled class
            saveBtn.onclick = () => updateQuantity(orderId, itemId, qtyInput.value);

            const closeBtn = document.createElement("button");
            closeBtn.textContent = "Close";
            closeBtn.className = "button outline"; // Styled class
            closeBtn.onclick = closePopup2;

            buttonContainer.appendChild(closeBtn);
            buttonContainer.appendChild(saveBtn);

            // Append buttons to the popup and display it
            popup.appendChild(buttonContainer);
            popup.style.display = "block";
        } else {
            alert("Failed to fetch lumber quantity. Please try again.");
        }
    } catch (error) {
        console.error("Error fetching lumber quantity:", error);
        alert("An error occurred while fetching lumber details.");
    }
}


async function updateQuantity(orderId, itemId, newQty) {
    try {
        // Send the updated quantity to the backend
        const response = await fetch("../../config/customer/updateQty.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ orderId, itemId, newQty })
        });

        const data = await response.json();

        if (data.success) {
            alert("Quantity updated successfully!");

            // Update the table row
            const tableRows = document.querySelectorAll("#orderDetails tbody tr");
            tableRows.forEach(row => {
                if (
                    row.children[0].textContent == orderId &&
                    row.children[1].textContent == itemId
                ) {
                    row.children[2].textContent = newQty; // Update quantity cell
                }
            });

            closePopup();
        } else {
            alert("Failed to update quantity. Please try again.");
        }
    } catch (error) {
        console.error("Error updating quantity:", error);
        alert("An error occurred while updating the quantity.");
    }
}

function closePopup2() {
    const popup = document.getElementById("popup-2");
    popup.style.display = "none";

    // Clean up Save button to avoid duplicates
    const saveBtn = popup.querySelector("button");
    if (saveBtn) popup.removeChild(saveBtn);
    document.getElementById("overlay").style.display = "none";
}








document.addEventListener('DOMContentLoaded', function() {
    const buttonElement = document.getElementById('action-button');
    const statusElement = document.getElementById('status');
    const buttonAddElement = document.getElementById('add-button');
    const buttonUpdateElement = document.getElementById('update-button');
    

   
    function updateButton() {
        if (statusElement.textContent === 'Confirmed') {
            buttonElement.textContent = 'Contact';
            buttonElement.onclick = function() {
                window.location.href = "http://localhost/Timberly/public/customer/contactDesigner.html";
            };

            buttonAddElement.style.display = 'none';
            buttonUpdateElement.textContent = 'Proceed to Pay';
            buttonUpdateElement.onclick = function() {
                window.location.href = "http://localhost/Timberly/public/customer/payment-details.html";
                // statusElement.textContent = 'Processing';
                // updateButton();
            };

        } else if (statusElement.textContent === 'Processing') {
            buttonElement.textContent = 'Track';
            buttonElement.onclick = function() {
                window.location.href = "http://localhost/Timberly/public/customer/trackOrder.html";
            };

            buttonUpdateElement.style.display = 'none';
            buttonAddElement.style.display = 'none';

        } else {
            buttonElement.textContent = 'Cancel Order';
            buttonElement.onclick = function() {
                //alert("Order Cancelled")
                buttonElement.onclick = async function() {
                    const confirmation = confirm("Are you sure you want to cancel this order?");
                    if (confirmation) {
                        try {
                            const response = await fetch(`../../config/customer/cancelOrder.php?orderId=${orderId}`, {
                                method: 'POST'
                            });
                            const result = await response.json();
        
                            if (result.success) {
                                alert("Order Cancelled Successfully");
                                window.location.href = "http://localhost/Timberly/public/customer/orderRawMaterialDetails.html";
                                statusElement.textContent = "Cancelled";
                                buttonElement.style.display = 'none';
                                updateButton(); // Refresh button logic
                            } else {
                                alert("Failed to cancel the order. Please try again.");
                            }
                        } catch (error) {
                            console.error("Error cancelling the order:", error);
                            alert("An error occurred while cancelling the order.");
                        }
                    }
                };
            };

            buttonAddElement.onclick = function(){
                showPopup();
            }

           
        }
    }

    function showPopup() {
        document.getElementById("overlay").style.display = "block";
        document.getElementById("popup").style.display = "block";

        const selectDesignRadio = document.getElementById('selectDesign');
        const inputDesignRadio = document.getElementById('inputDesign');
        const designOptionsDiv = document.getElementById('design-options');
        const imageInputDiv = document.getElementById('image-input');
        const selectedDesign = document.getElementById('selected-design');
        const designOptions = document.querySelectorAll('.design-option');
    
        // Event listener for radio button change
        document.querySelectorAll('input[name="designChoice"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (selectDesignRadio.checked) {
                    designOptionsDiv.style.display = 'block'; // Show design options
                    imageInputDiv.style.display = 'none';    // Hide image input
                } else if (inputDesignRadio.checked) {
                    imageInputDiv.style.display = 'block';   // Show image input
                    designOptionsDiv.style.display = 'none'; // Hide design options
                }
            });
        });
    
        // Event listener for selecting a design from the image dropdown
        designOptions.forEach(option => {
            option.addEventListener('click', function() {
                selectedDesign.src = this.src;  // Set the selected design image
            });
        });


        const designImageInput = document.getElementById('design-image');
        const imagePreview = document.getElementById('image-preview');

        // Listen for changes when the user uploads an image
        designImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0]; // Get the uploaded file
            if (file) {
                const reader = new FileReader();  // Create a FileReader to read the file
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;  // Set the image src to the uploaded file
                    imagePreview.style.display = 'block'; // Make the image visible
                };
                reader.readAsDataURL(file);  // Read the file as a data URL (base64)
            }
        });



        
      }   

    updateButton();
});



const popupMessage = document.getElementById('popup-message');
const overlay = document.getElementById('popup-overlay');
const closePopupButton = document.getElementById('close-popup');

closePopupButton.onclick = function(){
    closePopup();
}

  function closePopup() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("popup").style.display = "none";
  }


 












