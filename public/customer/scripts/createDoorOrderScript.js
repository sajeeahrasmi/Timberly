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
            window.location.href = "../../public/login.php";
        });
});



document.getElementById("add-item").addEventListener("click", function (e) {
    e.preventDefault();  

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

    let imagePath = "";
    let description = "";

    if (!category || !type || !qty || !length || !width || !thickness) {
        alert("Please fill out all fields.");
        return;
    }

    if(!isSelectDesign || !isInputDesign){
        alert("Please input or select a design");
        return;
    }

    if (isSelectDesign) {
        const selectedImg = document.getElementById("selected-design");
        imagePath = selectedImg.src;
        description = document.getElementById("productDescription").textContent;
    } else if (isInputDesign) {
        const fileInput = document.getElementById("customDesign");
        const file = fileInput.files[0];
        if (file) {
            imagePath = URL.createObjectURL(file); 
            description = "Custom Design";
        } else {
            alert("Please upload an image.");
            return;
        }
    }



    if (!category || !type || !qty || !length || !width || !thickness) {
        alert("Please fill out all fields.");
        return;
    }

    if (qty < 1 || qty > 20) {
        alert("Quantity should be between 1 and 20.");
        return;
    }

    if (length < 1 || length > 5) {
        alert("Length should be between 1 and 5 m.");
        return;
    }

    if (width < 10 || width > 1500) {
        alert("Width should be between 10 and 1500 mm.");
        return;
    }

    if (thickness < 10 || thickness > 50) {
        alert("Thickness should be between 10 and 50 mm.");
        return;
    }

    

    // Create and append the card
    const cardGrid = document.querySelector(".order-list");
    const card = document.createElement("div");
    card.classList.add("product");

    card.innerHTML = `
        <img src="${imagePath}" alt="Design" style="width: 100px; margin-bottom: 10px;">
        <h6><strong>Category:</strong> ${category}</h6>
        <p><strong>Description:</strong> ${description}</p>
        <p><strong>Type:</strong> ${type}</p>
        <p><strong>Length:</strong> ${length}m</p>
        <p><strong>Width:</strong> ${width}mm</p>
        <p><strong>Thickness:</strong> ${thickness}mm</p>
        <p><strong>Quantity:</strong> ${qty}</p>
        <p><strong>Additional Details:</strong> ${additionalDetails}</p>
    `;

    cardGrid.appendChild(card);
    cardCounter++;
    document.getElementById("noOfItem").textContent = `${cardCounter}`;
});



document.getElementById("customDesign").addEventListener("change", function () {
    const file = this.files[0];
    const preview = document.getElementById("imagePreview");
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});



async function placeDoorOrder() {
    try {
        const cardElements = document.querySelectorAll(".product");
        if (cardElements.length === 0) {
            alert("No items selected to order.");
            return;
        }

        
        const formData = new FormData();
        
        
        formData.append("userId", userId);
        formData.append("itemQty", cardElements.length);
        
        
        const items = [];
        
        Array.from(cardElements).forEach((card, index) => {
            
            const categoryText = card.querySelector("h6").textContent;
            const category = categoryText.replace("Category:", "").trim();
            
            const paragraphs = card.querySelectorAll("p");
            let description = "";
            let type = "";
            let quantity = "";
            let additionalDetails = "";

            let length = 0, width = 0, thickness = 0;
            
            paragraphs.forEach(p => {
                const text = p.textContent;
                if (text.includes("Description:")) {
                    description = text.replace("Description:", "").trim();
                } else if (text.includes("Type:")) {
                    type = text.replace("Type:", "").trim();
                } else if (text.includes("Length:")) {
                    const val = text.replace("Length:", "").replace("m", "").trim();
                    length = parseFloat(val);
                }else if (text.includes("Width:")) {
                    const val = text.replace("Width:", "").replace("mm", "").trim();
                    width = parseFloat(val);
                }else if (text.includes("Thickness:")) {
                    const val = text.replace("Thickness:", "").replace("mm", "").trim();
                    thickness = parseFloat(val);
                } else if (text.includes("Quantity:")) {
                    quantity = text.replace("Quantity:", "").trim();
                } else if (text.includes("Additional Details:")) {
                    additionalDetails = text.replace("Additional Details:", "").trim();
                }
            });
                   
            const imgElement = card.querySelector("img");
            let imgSrc = imgElement.src;
            let isCustomImage = false;
            let imagePath = "";

            
            if (imgSrc.startsWith("blob:")) {
                isCustomImage = true;
                const fileInput = document.getElementById("customDesign");
                if (fileInput && fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    formData.append(`image_${index}`, file);
                    imagePath = ""; 
                }
            } else {
                const baseUrl = "http://localhost/Timberly/";
                if (imgSrc.startsWith(baseUrl)) {
                    const imageFileName = imgSrc.split("/").pop();
                    imagePath = "../images/" + imageFileName;
                } else {
                    imagePath = imgSrc; 
                }
            }

            const item = {
                category: category,
                description: description,
                type: type,
                length: length,
                width: width, 
                thickness: thickness,
                quantity: parseInt(quantity),
                additionalDetails: additionalDetails,
                productId: window.productId || null,
                isCustomImage: isCustomImage,
                imageIndex: index,
                imagePath: imagePath
            };
            
            items.push(item);
        });
        
        formData.append("items", JSON.stringify(items));
        
        const response = await fetch('../../config/customer/placeDoorOrder.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert("Door/Window order placed successfully!");
            document.querySelector(".order-list").innerHTML = "";
            cardCounter = 0;
            document.getElementById("noOfItem").textContent = "0";
            
            window.location.href = `http://localhost/Timberly/public/customer/createDoorOrder.php`;
        } else {
            alert("Failed to place the order: " + (result.error || "Unknown error"));
        }
    } catch (error) {
        console.error("Error placing order:", error);
        alert("An error occurred while placing the order.");
    }
}