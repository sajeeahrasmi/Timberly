let userId = 0;
let orderId = 0;
let orderStatus = "";
let totalAmount = 0;
let count = 0;

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
              console.log(orderId);
              fetchOrderStatus();
              document.getElementById("orderID").textContent = `Order # ${item.orderId}`;

            totalAmount = totalAmount + item.qty * item.unitPrice;
            document.getElementById("payment-total").textContent = `Total: ${totalAmount}`
            count = count + 1;

              row.innerHTML = `
                  <td>${item.orderId}</td>
                  <td>${item.itemId}</td>
                  <td>${item.type}</td>
                  <td>${item.qty}</td>
                  <td>${item.unitPrice}</td>
                  <td>${item.status}</td>
                  <td>
                    <button class="button outline" style="margin-right: 10px; padding: 10px; border-radius: 10px;" onclick="window.location.href='http://localhost/Timberly/public/customer/trackOrderMaterials.php?orderId=${item.orderId}&itemId=${item.itemId}&userId=${userId}'">View</button>
                    <button class="button solid delete-btn" style=" padding: 10px; border-radius: 10px;">Delete</button>
                                    
                </td>
              `;

            const deleteButton = row.querySelector(".delete-btn");
            deleteButton.addEventListener("click", () => deleteOrderItem(item.itemId));


              tableBody.appendChild(row);
          });

          document.getElementById("noOfItems").textContent = `No.of Items: ${count}`
       
      } else {
          alert("Failed to fetch order details. Please try again.");
      }
  } catch (error) {
      console.error("Error fetching order details:", error);
      alert("An error occurred while fetching order details.");
  }
}

  //fetching the length
async function updateLengths() {
    const type = document.getElementById("type").value;
    const lengthSelect = document.getElementById("length");
    const widthSelect = document.getElementById("width");
    const thicknessSelect = document.getElementById("thickness");

    // Clear dependent dropdowns
    lengthSelect.innerHTML = '<option value="">--Select Length--</option>';
    widthSelect.innerHTML = '<option value="">--Select Width--</option>';
    thicknessSelect.innerHTML = '<option value="">--Select Thickness--</option>';

    if (type) {
        try {
            const response = await fetch(`../../config/customer/lumber.php?type=${type}`);
            const data = await response.json();

            // Populate the length dropdown
            data.lengths.forEach(length => {
                const option = document.createElement("option");
                option.value = length;
                option.textContent = length;
                lengthSelect.appendChild(option);
            });
        } catch (error) {
            console.error("Error fetching lengths:", error);
        }
    }
}

//fetching width
async function updateWidths() {
    const type = document.getElementById("type").value;
    const length = document.getElementById("length").value;
    const widthSelect = document.getElementById("width");
    const thicknessSelect = document.getElementById("thickness");

    // Clear dependent dropdown
    widthSelect.innerHTML = '<option value="">--Select Width--</option>';
    thicknessSelect.innerHTML = '<option value="">--Select Thickness--</option>';

    if (type && length) {
        try {
            const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}`);
            const data = await response.json();

            // Populate the width dropdown
            data.widths.forEach(width => {
                const option = document.createElement("option");
                option.value = width;
                option.textContent = width;
                widthSelect.appendChild(option);
            });
        } catch (error) {
            console.error("Error fetching widths:", error);
        }
    }
}

//fetching thickness
async function updateThicknesses() {
    const type = document.getElementById("type").value;
    const length = document.getElementById("length").value;
    const width = document.getElementById("width").value;
    const thicknessSelect = document.getElementById("thickness");

    // Clear thickness dropdown
    thicknessSelect.innerHTML = '<option value="">--Select Thickness--</option>';

    if (type && length && width) {
        try {
            const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}&width=${width}`);
            const data = await response.json();

            // Populate the thickness dropdown
            data.thicknesses.forEach(thickness => {
                const option = document.createElement("option");
                option.value = thickness;
                option.textContent = thickness;
                thicknessSelect.appendChild(option);
            });
        } catch (error) {
            console.error("Error fetching thicknesses:", error);
        }
    }
}

//fetching qty
async function updateQty() {
    const type = document.getElementById("type").value;
    const length = document.getElementById("length").value;
    const width = document.getElementById("width").value;
    const thickness = document.getElementById("thickness").value;
    const qtyLabel = document.getElementById("qty");
    const priceLabel = document.getElementById("price");

    // Reset the label text
    qtyLabel.value = 1;

    if (type && length && width && thickness) {
        try {
            const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}&width=${width}&thickness=${thickness}`);
            const data = await response.json();

            console.log("Response Data:", data); // Log response for debugging

            // Update the quantity label
            if (data.qtys && data.price) {
                priceLabel.textContent = `Unit Price: ${data.price}`;
                qtyLabel.max = data.qtys;
            } else {
                priceLabel.textContent = "Price: Not Available";
                qtyLabel.max = 1;
            }
        } catch (error) {
            console.error("Error fetching quantity:", error);
            qtyLabel.textContent = "Qty: Error";
        }
    } else {
        qtyLabel.textContent = "Qty: Select all options";
    }
}

async function fetchOrderStatus(){
    const response = await fetch(`../../config/customer/orderRawMaterialDetails.php?action=getStatus&orderId=${orderId}&userId=${userId}`);
    const data = await response.json();

    if(data.success){
        orderStatus = `${data.status}`;
        document.getElementById("status").textContent = orderStatus;
        console.log(orderStatus);
    }

    updateButton();
}

    
async function updateButton() {
    const buttonElement = document.getElementById('action-button');
    const buttonAddElement = document.getElementById('addItem');
    const statusElement = document.getElementById("status");

        if (statusElement.textContent === 'Pending') {
            buttonElement.onclick = function() {
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
                                window.location.href = "http://localhost/Timberly/public/customer/createRawMaterialOrder.html";
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

        } else {    
           buttonAddElement.disabled = true;
           buttonElement.style.display = 'none';
        }
    }

       


// document.addEventListener('DOMContentLoaded', function() {
//     const buttonElement = document.getElementById('action-button');
//     const statusElement = document.getElementById('status');
//     const buttonAddElement = document.getElementById('addItem');
//     const buttonUpdateElement = document.getElementById('update-button');
    

   
//     function updateButton() {
//         if (statusElement.textContent === 'Confirmed') {
//             buttonElement.textContent = 'Contact';
//             buttonElement.onclick = function() {
//                 window.location.href = "http://localhost/Timberly/public/customer/contactDesigner.html";
//             };

//             buttonAddElement.style.display = 'none';
//             buttonUpdateElement.textContent = 'Proceed to Pay';
//             buttonUpdateElement.onclick = function() {
//                 window.location.href = "http://localhost/Timberly/public/customer/payment-details.html";
//                 // statusElement.textContent = 'Processing';
//                 // updateButton();
//             };

//         } else if (statusElement.textContent === 'Processing') {
//             buttonElement.textContent = 'Track';
//             buttonElement.onclick = function() {
//                 window.location.href = "http://localhost/Timberly/public/customer/trackOrder.html";
//             };

//             buttonUpdateElement.style.display = 'none';
//             buttonAddElement.style.display = 'none';

//         } else {
//             buttonElement.textContent = 'Cancel Order';
//             buttonElement.onclick = function() {
//                 //alert("Order Cancelled")
//                 buttonElement.onclick = async function() {
//                     const confirmation = confirm("Are you sure you want to cancel this order?");
//                     if (confirmation) {
//                         try {
//                             const response = await fetch(`../../config/customer/cancelOrder.php?orderId=${orderId}`, {
//                                 method: 'POST'
//                             });
//                             const result = await response.json();
        
//                             if (result.success) {
//                                 alert("Order Cancelled Successfully");
//                                 window.location.href = "http://localhost/Timberly/public/customer/createRawMaterialOrder.html";
//                                 statusElement.textContent = "Cancelled";
//                                 buttonElement.style.display = 'none';
//                                 updateButton(); // Refresh button logic
//                             } else {
//                                 alert("Failed to cancel the order. Please try again.");
//                             }
//                         } catch (error) {
//                             console.error("Error cancelling the order:", error);
//                             alert("An error occurred while cancelling the order.");
//                         }
//                     }
//                 };
//             };

//             buttonAddElement.onclick = function(){
//                 showPopup();
//             }

           
//         }
//     }

//     function showPopup() {
//         document.getElementById("overlay").style.display = "block";
//         document.getElementById("popup").style.display = "block";

//         const selectDesignRadio = document.getElementById('selectDesign');
//         const inputDesignRadio = document.getElementById('inputDesign');
//         const designOptionsDiv = document.getElementById('design-options');
//         const imageInputDiv = document.getElementById('image-input');
//         const selectedDesign = document.getElementById('selected-design');
//         const designOptions = document.querySelectorAll('.design-option');
    
//         // Event listener for radio button change
//         document.querySelectorAll('input[name="designChoice"]').forEach(radio => {
//             radio.addEventListener('change', function() {
//                 if (selectDesignRadio.checked) {
//                     designOptionsDiv.style.display = 'block'; // Show design options
//                     imageInputDiv.style.display = 'none';    // Hide image input
//                 } else if (inputDesignRadio.checked) {
//                     imageInputDiv.style.display = 'block';   // Show image input
//                     designOptionsDiv.style.display = 'none'; // Hide design options
//                 }
//             });
//         });
    
//         // Event listener for selecting a design from the image dropdown
//         designOptions.forEach(option => {
//             option.addEventListener('click', function() {
//                 selectedDesign.src = this.src;  // Set the selected design image
//             });
//         });


//         const designImageInput = document.getElementById('design-image');
//         const imagePreview = document.getElementById('image-preview');

//         // Listen for changes when the user uploads an image
//         designImageInput.addEventListener('change', function(event) {
//             const file = event.target.files[0]; // Get the uploaded file
//             if (file) {
//                 const reader = new FileReader();  // Create a FileReader to read the file
//                 reader.onload = function(e) {
//                     imagePreview.src = e.target.result;  // Set the image src to the uploaded file
//                     imagePreview.style.display = 'block'; // Make the image visible
//                 };
//                 reader.readAsDataURL(file);  // Read the file as a data URL (base64)
//             }
//         });



        
//       }   

//     updateButton();
// });

const popupMessage = document.getElementById('popup-message');
const overlay = document.getElementById('popup-overlay');
const closePopupButton = document.getElementById('close-popup');

closePopupButton.onclick = function(){
    close();
}

async function showPopup() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("popup").style.display = "block";
  }

async function closePopup() {
    const type = document.getElementById("type").value;
    const length = document.getElementById("length").value;
    const width = document.getElementById("width").value;
    const thickness = document.getElementById("thickness").value;
    const qty = document.getElementById("qty").value;

    if (!type || !length || !width || !thickness || !qty) {
        alert("Please fill out all fields before adding to the selection.");
        return;
    }

    const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}&width=${width}&thickness=${thickness}`);
    const lumber = await response.json();

    try {
        const response = await fetch(`../../config/customer/orderRawMaterialDetails.php?action=addItem&type=${type}&length=${length}&width=${width}&thickness=${thickness}&qty=${qty}&orderId=${orderId}&userId=${userId}&lumberId=${lumber.lumberId}`);
        const data = await response.json();

        if (data.success) {
            alert(`Lumber added successfully!`);
        } else {
            alert(`Error: ${data.error}`);
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Couldn't add the lumber.");
    }

    document.getElementById("overlay").style.display = "none";
    document.getElementById("popup").style.display = "none";
}

async function close() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("popup").style.display = "none";
}


document.getElementById("filter").addEventListener("click", () => {
    const itemStatus = document.getElementById("order-status").value.toLowerCase();
    const woodType = document.getElementById("wood-type").value.toLowerCase();

    const table = document.getElementById("orderDetails");
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const statusCell = row.cells[5].textContent.toLowerCase(); // Column for Status
        const typeCell = row.cells[2].textContent.toLowerCase(); // Column for Type

        const matchesStatus = itemStatus === "" || statusCell === itemStatus;
        const matchesType = woodType === "" || typeCell === woodType;

        if (matchesStatus && matchesType) {
            row.style.display = ""; // Show the row
        } else {
            row.style.display = "none"; // Hide the row
        }
    });
});

async function deleteOrderItem(itemId) {
    try {
        const response = await fetch(`../../config/customer/orderRawMaterialDetails.php?action=deleteItem&orderId=${orderId}&itemId=${itemId}&userId=${userId}`);

        const data = await response.json();

        if (data.success) {
            alert("Item deleted successfully");
            // Reload the order details table
            fetchOrderDetails();
        } else {
            alert("Failed to delete the item: " + data.error);
        }
    } catch (error) {
        console.error("Error deleting order item:", error);
        alert("An error occurred while deleting the item.");
    }
}