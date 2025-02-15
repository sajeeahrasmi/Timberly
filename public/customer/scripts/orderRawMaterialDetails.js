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
                buttonElement.onclick = cancelOrder();
            };

            buttonAddElement.onclick = function(){
                showPopup();
            }

        } else {    
           buttonAddElement.disabled = true;
           buttonElement.style.display = 'none';
        }
    }

       
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

async function cancelOrder(){
    const confirmation = confirm ("Are you sure you want to cancel this order?");
    if(confirmation){
        try {
            const response = await fetch(`../../config/customer/cancelOrders.php?action=cancelLumber&orderId=${orderId}`);

            const text = await response.text(); 
            console.log("Raw response:", text);
            
            const result = JSON.parse(text);

            if (result.success) {
                alert("Order Cancelled successfully");
                window.location.href = `http://localhost/Timberly/public/customer/orderHistory.php`;
            } else {
               alert("Failed to cancel the order: " + (result.error || "Unknown error"));
            }

        } catch (error) {
            console.error("Error cancelling the order:", error);
            alert("An error occurred while cancelling the order.");
        }
    }
}