
let orderStatus = "";
let totalAmount = 0;
let count = 0;
let lumberQty = 0;

document.addEventListener('DOMContentLoaded', function() { 
    const buttonElement = document.getElementById('action-button');
    const buttonAddElement = document.getElementById('addItem');
    const statusElement = document.getElementById("status");

        if (statusElement.textContent === 'Pending') {
            buttonElement.disabled = false;
            buttonAddElement.onclick = function(){
                showPopup();
            }

        } else if (statusElement.textContent === 'Confirmed') {
            buttonElement.disabled = false;
            buttonAddElement.disabled = true;
            buttonAddElement.style.display = 'none';

        }else if (statusElement.textContent === 'Processing' || statusElement.textContent === 'Completed'){    
           buttonElement.disabled = true;
           buttonElement.style.display = 'none';
           buttonAddElement.style.display = 'none';
           document.querySelectorAll('.delete-button').forEach(btn => {
            btn.style.display = 'none';
        });
        }else{
            buttonAddElement.disabled = true;
           buttonElement.style.display = 'none';
        }
});
async function updateButton() {
    
}



document.getElementById('close-popup').onclick = function(){
    close();
}

async function showPopup() {
    document.getElementById("overlay").style.display = "block";
    document.getElementById("popup").style.display = "block";
}

async function closePopup(userId, orderId) {
    const type = document.getElementById("type").value;
    const length = document.getElementById("length").value;
    const width = document.getElementById("width").value;
    const thickness = document.getElementById("thickness").value;
    const qty = document.getElementById("qty").value;

    if (!type || !length || !width || !thickness || !qty) {
        alert("Please fill out all fields before adding to the selection.");
        return;
    }

    if (qty > lumberQty) {
        alert(`Please select quantity less than ${lumberQty} .`);
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
        const statusCell = row.cells[4].textContent.toLowerCase(); // Column for Status
        const typeCell = row.cells[1].textContent.toLowerCase(); // Column for Type

        const matchesStatus = itemStatus === "" || statusCell === itemStatus;
        const matchesType = woodType === "" || typeCell === woodType;

        if (matchesStatus && matchesType) {
            row.style.display = ""; // Show the row
        } else {
            row.style.display = "none"; // Hide the row
        }
    });
});

async function deleteItem(itemId, orderId, userId) {
    
    try {
        const response = await fetch(`../../config/customer/orderRawMaterialDetails.php?action=deleteItem&orderId=${orderId}&itemId=${itemId}&userId=${userId}`);

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



async  function cancelOrder(orderId){
    const confirmation = confirm ("Are you sure you want to cancel this order?");
    if(confirmation){
        try {
            const response = await fetch(`../../config/customer/cancelOrders.php?action=cancelLumber&orderId=${orderId}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

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


async function updateQty() {
    const type = document.getElementById("type").value;
    const length = document.getElementById("length").value;
    const width = document.getElementById("width").value;
    const thickness = document.getElementById("thickness").value;
    const qtyLabel = document.getElementById("qty");
    const priceLabel = document.getElementById("price");

    qtyLabel.value = 1;

    if (type && length && width && thickness) {
        try {
            const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}&width=${width}&thickness=${thickness}`);
            const data = await response.json();

            console.log("Response Data:", data); 

            if (data.qtys && data.price) {
                priceLabel.textContent = `Unit Price: ${data.price}`;
                qtyLabel.max = data.qtys;
                lumberQty = data.qtys;
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
        const response = await fetch(`../../config/customer/changeDate.php?action=updateLumberDriverDate&orderId=${orderId}&newDate=${newDateStr}&oldDate=${currentDateStr}`);
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