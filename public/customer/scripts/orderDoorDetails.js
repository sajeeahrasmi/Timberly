const statusElement = document.getElementById('status');
const buttonAddItem = document.getElementById('addItem');

document.addEventListener('DOMContentLoaded', function() {   
    function updateButton() {
        if (statusElement.textContent === 'Confirmed') {
            buttonPay.disabled = false;
            buttonAddItem.disabled = true;

        } else if (statusElement.textContent === 'Processing') {
            buttonElement.style.display = 'none';
            buttonAddItem.style.display = 'none';
            buttonAddItem.disabled = true;

        } else {
            buttonPay.disabled = false;
            buttonElement.textContent = 'Cancel Order';
        }
    }

    updateButton();
   
});

async function filterItems(params) {
    const status = document.getElementById("item-status").value.toLowerCase();
    const category = document.getElementById("item-category").value.toLowerCase();
    const type = document.getElementById("item-type").value.toLowerCase();

    const table = document.getElementById("orderDetails");
    const rows = table.querySelectorAll("tbody tr");

    rows.forEach(row => {
        const statusCell = row.cells[5].textContent.toLowerCase(); 
        const typeCell = row.cells[2].textContent.toLowerCase();
        const categoryCell = row.cells[1].textContent.toLowerCase();

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

async function deleteItem(id, orderId) {
    const status = statusElement.textContent;
    if(status !== 'Pending' && status !== 'Confirmed'){
        alert("Cannot delete Item!");
        return;
    }

    try {
        const response = await fetch(`../../config/customer/updateDoorOrder.php?action=deleteItem&orderId=${orderId}&id=${id}`);

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
            const response = await fetch(`../../config/customer/cancelOrders.php?action=cancelDoor&orderId=${orderId}`);
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

a

 document.getElementById("customDesign").addEventListener("change", function () {
    const file = this.files[0];
    const preview = document.getElementById("imagePreview");
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});

async function addItem(orderId) {
    try {
        const designChoice = document.querySelector('input[name="designChoice"]:checked');
        const isSelectDesign = designChoice && designChoice.value === "select-design";
        const isInputDesign = designChoice && designChoice.value === "input-design";

        const category = document.getElementById("category").value;
        const type = document.getElementById("type").value;
        const length = document.getElementById("length").value;
        const width = document.getElementById("width").value;
        const thickness = document.getElementById("thickness").value;
        const qty = document.getElementById("qty").value;
        const additionalDetails = document.getElementById("additionalDetails").value;

        if (!category || !type || !qty || !length || !width || !thickness) {
            alert("Please fill out all fields.");
            return;
        }

        if (qty < 1 || qty > 20) {
            alert("Quantity should be between 1 and 20.");
            return;
        }

        if (length < 1 || length > 5) {
            alert("Length should be between 1 and 5.");
            return;
        }

        if (width < 1 || width > 1500) {
            alert("Width should be between 1 and 1500.");
            return;
        }

        if (thickness < 1 || thickness > 50) {
            alert("Thickness should be between 1 and 50.");
            return;
        }

        let imagePath = "";
        let isCustomImage = false;
        let description = "";

        const formData = new FormData();
        formData.append("orderId", orderId);  // Optional if needed in PHP

        if (isSelectDesign) {
            const selectedImg = document.getElementById("selected-design");
            const imgSrc = selectedImg.src;
            const baseUrl = "http://localhost/Timberly/";
            const imageFileName = imgSrc.split("/").pop();
            imagePath = "../images/" + imageFileName;
            description = document.getElementById("productDescription").textContent;
        } else if (isInputDesign) {
            const fileInput = document.getElementById("customDesign");
            if (!fileInput || fileInput.files.length === 0) {
                alert("Please upload a design image.");
                return;
            }

            const file = fileInput.files[0];
            formData.append("image_0", file);  // Same as multi-item
            isCustomImage = true;
            description = "Custom Design";
            imagePath = "";  // Will be set server-side
        } else {
            alert("Please select a design option.");
            return;
        }

        const item = {
            category: category,
            description: description,
            type: type,
            length: parseFloat(length),
            width: parseFloat(width),
            thickness: parseFloat(thickness),
            quantity: parseInt(qty),
            additionalDetails: additionalDetails,
            productId: window.productId || null,
            isCustomImage: isCustomImage,
            imageIndex: 0,
            imagePath: imagePath
        };

        formData.append("orderId", orderId);
        formData.append("item", JSON.stringify([item]));

        const response = await fetch('../../config/customer/updateDoorOrder.php?action=addItem', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert("Item added successfully!");
            
        } else {
            alert("Failed to place the order: " + (result.error || "Unknown error"));
        }

    } catch (error) {
        console.error("Error adding item:", error);
        alert("An error occurred while adding the item.");
    }
}
