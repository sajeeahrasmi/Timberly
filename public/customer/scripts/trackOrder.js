let urlParams ;
let orderId ;
let itemId ;
let userId ;

document.addEventListener("DOMContentLoaded", async () => {
    urlParams = new URLSearchParams(window.location.search);
    orderId = urlParams.get('orderId');
    itemId = urlParams.get('itemId');
    userId = urlParams.get('userId');

    // Validate parameters
    if (!orderId || !itemId || !userId) {
        alert("Invalid order details.");
        return;
    }

    
    try {
        const response = await fetch(`../../config/customer/fetchRawMaterialDetails.php?action=fetchDetails&orderId=${orderId}&itemId=${itemId}&userId=${userId}`);
        const data = await response.json();

        if (data.success) {
           
            document.getElementById("order-title").textContent = `Order #${data.orderId}`;
            document.getElementById("item-title").textContent = `Item #${data.itemId}`;
            document.getElementById("description").textContent = data.description;
            document.getElementById("wood-type").textContent = data.woodType;
            document.getElementById("dimensions").textContent = data.dimensions;
            document.getElementById("quantity").textContent = data.quantity;
            document.getElementById("price").textContent = data.price;
            document.getElementById("item-status").textContent = data.status;

            
            updateButtonsBasedOnStatus(data.status);
        } else {
            alert("Failed to fetch order details.");
        }
    } catch (error) {
        console.error("Error fetching order details:", error);
        alert("An error occurred.");
    }
});


function updateButtonsBasedOnStatus(status) {
    document.getElementById("edit-btn").disabled = status !== "Pending";
    document.getElementById("view-location-btn").disabled = status !== "Delivering";
    document.getElementById("leave-review-btn").disabled = status !== "Completed";
}
