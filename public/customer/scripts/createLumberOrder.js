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

let cardIdCounter = 0; // To generate unique IDs for each card

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

    try {
        // Fetch the lumber ID from the database
        const response = await fetch(`../../config/customer/lumber.php?type=${type}&length=${length}&width=${width}&thickness=${thickness}`);
        const data = await response.json();

        if (data.qtys && data.price) {
            // Create a new card
            const cardGrid = document.querySelector(".order-list");
            const card = document.createElement("div");
            card.classList.add("product");

            // Generate content for the card
            card.innerHTML = `
                <h6><strong>Lumber ID:</strong> ${data.lumberId}</h6>
                <p><strong>Quantity:</strong> ${qty}</p>
                <p><strong>Unit Price:</strong> ${data.price}</p>
            `;

            // Add delete button for the card
            // const deleteBtn = document.createElement("button");
            // deleteBtn.textContent = "Remove";
            // deleteBtn.onclick = () => card.remove();
            // card.appendChild(deleteBtn);

            // Add the card to the grid
            cardGrid.appendChild(card);
        } else {
            alert("Item details not available.");
        }
    } catch (error) {
        console.error("Error adding card:", error);
        alert("Failed to add item. Try again.");
    }
}




