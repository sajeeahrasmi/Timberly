let cardCounter = 0;
let userId = 0;


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
            console.log(userId)
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Session expired. Please log in again.");
            window.location.href = "../../public/login.html";
        });
});


async function addCard(productId, description) {
    const category = document.getElementById("category").value;
    const image = document.getElementById("selected-design").value;
    const type = document.getElementById("type").value;
    const qty = document.getElementById("qty").value;
    const size = document.getElementById("size").value;
    const additionalDetails = document.getElementById("additionalDetails").value;

    if (!category || !type || !qty || !size) {
        alert("Please fill out all fields before adding to the selection.");
        return;
    }else if (qty < 1 || qty > 20){
        alert("Quantity should be in between 1 and 20");
        return;
    }

    try {       
            const cardGrid = document.querySelector(".order-list");
            const card = document.createElement("div");
            card.classList.add("product");
            cardCounter = cardCounter + 1;
            console.log(description);
            
            card.innerHTML = `
                <h6><strong>Product ID:</strong> <span id="ItemProductid"> ${productId}</span></h6>
                <p><strong>Description:</strong> <span id="itemDes"> ${description}</span></p>
                <p><strong>Quantity:</strong> <span id="itemQty"> ${qty}</span></p>
                <p><strong>Size:</strong><span id="itemSize">${size}</span></p>
                <p><strong>Type:</strong> <span id="itemType"> ${type}</span></p>
                <p><strong></strong> <span id="itemDetails"> ${additionalDetails}</span></p>
            `;
            cardGrid.appendChild(card);
            document.getElementById("noOfItem").textContent = `${cardCounter}`;
        
    } catch (error) {
        console.error("Error adding card:", error);
        alert("Failed to add item. Try again.");
    }
}


async function placeOrder() {
    try {
        const cardElements = document.querySelectorAll(".product");
        if (cardElements.length === 0) {
            alert("No items selected to order.");
            return;
        }

        const items = Array.from(cardElements).map(card => ({
            productId: card.querySelector("#ItemProductid").textContent.trim(),
            type: card.querySelector("#itemType").textContent.trim(),
            qty: parseInt(card.querySelector("#itemQty").textContent.trim()),
            size: card.querySelector("#itemSize").textContent.trim(),
            details: card.querySelector("#itemDetails").textContent.trim()
        }));

        const orderData = {
            userId: userId,
            itemQty: items.length
        };

        const response = await fetch('../../config/customer/placeFurnitureOrder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ order: orderData, items: items })
        });

        const result = await response.json();

        if (result.success) {
            alert("Order placed successfully!");
           // document.querySelector(".card-grid").innerHTML = ""; 
            location.reload();
            window.location.href = `http://localhost/Timberly/public/customer/createFurnitureOrder.php`;
            
        } else {
            alert("Failed to place the order. Please try again.");
        }

      
    } catch (error) {
        console.error("Error placing order:", error);
        alert("An error occurred while placing the order.");
    }
}