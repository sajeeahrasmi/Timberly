let userId = 0;

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

let lumberQty = 0;
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

let cardIdCounter = 0; 
let total = 0;

async function addCard() {
    const type = document.getElementById("type").value;
    const length = document.getElementById("length").value;
    const width = document.getElementById("width").value;
    const thickness = document.getElementById("thickness").value;
    const qty = document.getElementById("qty").value;
    const priceLabel = document.getElementById("price").textContent;

    if (!type || !length || !width || !thickness || !qty) {
        alert("Please fill out all fields before adding to the selection.");
        return;
    }

    if (qty > lumberQty || qty <1) {
        alert(`Please select quantity greater than 0 and less than ${lumberQty}.`);
        return;
    }

    try {
        const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}&width=${width}&thickness=${thickness}`);
        const data = await response.json();

        if (data.qtys && data.price) {
            const cardGrid = document.querySelector(".order-list");
            const card = document.createElement("div");
            card.classList.add("product");
            cardIdCounter = cardIdCounter + 1;

            card.innerHTML = `
                <h6><strong>Lumber ID:</strong> <span id="ItemLumberid"> ${data.lumberId}</span></h6>
                <p><strong>Quantity:</strong> <span id="itemQty"> ${qty}</span></p>
                <p><strong>Unit Price:</strong><span id="itemPrice">${data.price}</span></p>
            `;
            cardGrid.appendChild(card);
            total = total + qty * data.price;
            document.getElementById("noOfItem").textContent = `${cardIdCounter}`;
            document.getElementById("noOfItems").textContent = `${cardIdCounter}`;
            document.getElementById("total").textContent = `Rs. ${total}`;
        } else {
            alert("Item details not available.");
        }
    } catch (error) {
        console.error("Error adding card:", error);
        alert("Failed to add item. Try again.");
    }
}

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
            window.location.href = "../../public/login.php";
        });
});

async function placeOrder() {
    try {
        const cardElements = document.querySelectorAll(".product");
        if (cardElements.length === 0) {
            alert("No items selected to order.");
            return;
        }

        const items = Array.from(cardElements).map(card => ({
            lumberId: card.querySelector("#ItemLumberid").textContent.trim(),
            qty: parseInt(card.querySelector("#itemQty").textContent.trim()),
            price: parseFloat(card.querySelector("#itemPrice").textContent.trim())
        }));

        const totalAmount = items.reduce((sum, item) => sum + item.qty * item.price, 0);

        const orderData = {
            userId: userId, 
            itemQty: items.length,
            totalAmount: totalAmount
        };

        const response = await fetch('../../config/customer/placeLumberOrder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ order: orderData, items: items })
        });

        const result = await response.json();

        if (result.success) {
            alert("Order placed successfully!");
            window.location.href = `http://localhost/Timberly/public/customer/orderHistory.php`;
            
        } else {
            alert("Order placement failed. Please try again and make sure identical items are grouped together instead of adding them separately.");
            location.reload();
        }
    } catch (error) {
        console.error("Error placing order:", error);
        alert("An error occurred while placing the order.");
    }
}



