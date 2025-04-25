                            
const buttonElement = document.getElementById('action-button');
const statusElement = document.getElementById('status');
const buttonAddItem = document.getElementById('addItem');
const buttonPay = document.getElementById('pay'); 


document.addEventListener('DOMContentLoaded', function() {   
    function updateButton() {
        if (statusElement.textContent === 'Confirmed') {
            buttonPay.disabled = false;
            buttonAddItem.disabled = true;
            buttonAddItem.style.display = 'none';

        } else if (statusElement.textContent === 'Processing' || statusElement.textContent === 'Completed') {
            buttonElement.style.display = 'none';
            buttonAddItem.style.display = 'none';
            buttonAddItem.disabled = true;
            document.querySelectorAll('.delete-button').forEach(btn => {
                btn.style.display = 'none';
            });

        } else {
            buttonPay.disabled = false;
            buttonElement.textContent = 'Cancel Order';
        }
    }

    updateButton();
   
});


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


function showPopup() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("popup").style.display = "block";   
} 
    
function closePopup() {
    document.getElementById("overlay").style.display = "none";
    document.getElementById("popup").style.display = "none";
}


async function addItem(productId, orderId) {
   // alert (productId);
    //now put the function to add item
    const type = document.getElementById('type').value;
    const qty = document.getElementById('qty').value;
    const size = document.getElementById('size').value;
    const details = document.getElementById('additionalDetails').value;

    if(!type || !qty || !size){
        alert("Please fill the columns");
        return;
    }

    try {
        
        const response = await fetch(`../../config/customer/updateFurnitureOrder.php?action=addItem&furnitureId=${productId}&orderId=${orderId}&type=${type}&qty=${qty}&size=${size}&details=${details}`);
        const data = await response.json();

        if (data.success) {
            alert(`Item added successfully!`);
        } else {
            alert(`Error: ${data.error}`);
        }

    } catch (error) {
        console.error("Error:", error);
        alert("Couldn't add the item.");
    }

    closePopup();
}

async function deleteItem(id, orderId) {
    const status = statusElement.textContent
    if(status !== 'Pending' && status !== 'Confirmed'){
        alert("Cannot delete Item!");
        return;
    }

    try {
        const response = await fetch(`../../config/customer/updateFurnitureOrder.php?action=deleteItem&orderId=${orderId}&id=${id}`);

        const data = await response.json();

        if (data.success) {
            alert("Item deleted successfully");
            
        } else {
            alert("Failed to delete the item: " + data.error);
        }
    } catch (error) {
        console.error("Error deleting order item:", error);
        alert("An error occurred while deleting the item.");
    }
}

async function filterItems(params) {
    const status = document.getElementById("item-status").value.toLowerCase();
    const category = document.getElementById("item-category").value.toLowerCase();
    const type = document.getElementById("item-type").value.toLowerCase();

    const table = document.getElementById("orderDetails");
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const statusCell = row.cells[7].textContent.toLowerCase(); 
        const typeCell = row.cells[3].textContent.toLowerCase();
        const categoryCell = row.cells[2].textContent.toLowerCase();

        const matchesStatus = status === "" || statusCell === status;
        const matchesCategory = category === "" || categoryCell === category;
        const matchesType = type === "" || typeCell === type;

        if (matchesStatus && matchesType && matchesCategory) {
            row.style.display = ""; 
        } else {
            row.style.display = "none"; 
        }
    });
}

async function changeDate(orderId) {
    const currentDateStr = document.getElementById("currentDateDriver").textContent.trim();
    const newDateStr = document.getElementById("newDateInputDriver").value;

    if (!newDateStr) {
        alert("Please select a date.");
        return;
    }

    const currentDate = new Date(currentDateStr);
    const newDate = new Date(newDateStr);

    const timeDiff = newDate - currentDate;
    const dayDiff = timeDiff / (1000 * 60 * 60 * 24);

    if (dayDiff <= 0 || dayDiff > 3) {
        alert("New date must be within 3 days after the current date.");
        return;
    }

    try {
        const response = await fetch(`../../config/customer/changeDate.php?action=updateFurnitureDriverDate&orderId=${orderId}&newDate=${newDateStr}&oldDate=${currentDateStr}`);
        const data = await response.json();

        if (data.success) {
            alert("Delivery date successfully updated.");
            location.reload();
        } else {
            alert(data.message || "Date change not allowed or failed.");
        }
    } catch (error) {
        console.error("Error updating date:", error);
        alert("An error occurred while updating the date.");
    }
}