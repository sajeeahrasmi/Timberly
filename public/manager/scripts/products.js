document.addEventListener('DOMContentLoaded', () => {
    // Tab switching functionality
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });

    // Product card click handlers
   /* const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', () => showPopup(card.dataset.name));
    });*/

    // Handle Create Product button
    const createProductBtn = document.querySelector('.create-product-btn');
    const modal = document.getElementById('create-order-modal');
    const closeModalBtn = document.querySelector('.close-modal');

    createProductBtn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    closeModalBtn.addEventListener('click', () => {
        console.log('Close button clicked'); // Debugging line
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    const submitButton = document.querySelector('.create-order-form button[type="submit"]');
    const confirmationPopup = document.getElementById('confirmation-popup');
    const confirmSubmitButton = document.getElementById('confirm-submit');
    const cancelSubmitButton = document.getElementById('cancel-submit');
    const createOrderModal = document.getElementById('create-order-modal');

    // Function to open the confirmation popup
    const openConfirmationPopup = (event) => {
        event.preventDefault(); 
        if (validateForm()) { 
            confirmationPopup.style.display = 'block';
        }
    };

    // Function to handle confirmation
    function confirmSubmit() {
        // Proceed with form submission
        alert("Success");
        createOrderModal.style.display = 'none';
        confirmationPopup.style.display = 'none';
    }

    // Function to close the confirmation popup
    const closeConfirmationPopup = () => {
        confirmationPopup.style.display = 'none';
    };

    // Attach event listeners
    submitButton.addEventListener('click', openConfirmationPopup);
    confirmSubmitButton.addEventListener('click', confirmSubmit);
    cancelSubmitButton.addEventListener('click', closeConfirmationPopup);
});

// Validate Form Function
function validateForm() {
    const materialType = document.getElementById('material_type').value;
    const customMaterial = document.getElementById('custom_material_type').value;
    const unitPrice = parseFloat(document.getElementById('unit_price').value);
    const productImage = document.getElementById('product_image').value;
    const productCategory = document.getElementById('product_category').value;

    if (materialType === '') {
        alert('Please select a material type.');
        return false;
    }

    if (materialType === 'other' && customMaterial === '') {
        alert('Please specify a custom material.');
        return false;
    }

    if (unitPrice <= 0) {
        alert('Unit price must be greater than 0.');
        return false;
    }

    if (!productImage) {
        alert('Please upload a product image.');
        return false;
    }

    if (productCategory === '') {
        alert('Please select a product category.');
        return false;
    }

    return true;
}


// Check for custom material type
function checkCustomMaterial(select) {
    const customMaterialInput = document.getElementById('custom_material_type');
    const customMaterialLabel = document.getElementById('custom_material_label');
    if (select.value === 'other') {
        customMaterialInput.style.display = 'block';
        customMaterialLabel.style.display = 'block';
    } else {
        customMaterialInput.style.display = 'none';
        customMaterialLabel.style.display = 'none';
    }
}

// Popup Function for Detailed View
/*function showPopup(productName) {
    // Logic to display the detailed product information in the popup
    document.getElementById('popup-title').textContent = productName;
    // Add any other details you want to display
    document.getElementById('popup').style.display = 'block';
}

document.querySelector('.close-popup')?.addEventListener('click', () => {
    document.getElementById('popup').style.display = 'none';
});
*/


document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('edit-product-modal');
    const closeModalBtn = editModal.querySelector('.close-modal');
    const dynamicFields = document.getElementById('dynamic-fields');
    
    // Open Edit Product Modal
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productCard = button.closest('.product-card');
            const productName = productCard.dataset.name;
            const productCategory = productCard.id; 
            console.log(productName, " " , productCategory) // Assuming productCard has an 'id' attribute
    
            getProductDetails(productCategory, productName)
                .then(productDetails => {
                    // Dynamically populate the form based on product category
                    dynamicFields.innerHTML = '';  // Clear previous content
                    populateEditForm(productDetails, productCategory); // Function to populate the form
    
                    // Display the modal
                    editModal.style.display = 'block';
                });
        });
    });
    

    // Close Modal
    closeModalBtn.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });

    // Function to get product details (mocking it here, you would need to fetch actual data)
    function getProductDetails(category, productName) {
        return fetch(`../../api/editProducts.php?category=${category}&productName=${productName}`)
            .then(response => response.json())
            .then(data => {
                return data;  // Returning the product details from the database
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
                return {};  // Return empty object on error
            });
    }
    

    // Function to populate the edit form dynamically based on product category
    function populateEditForm(details, category) {
        if (!details || Object.keys(details).length === 0) {
            // If no product details were returned, show a message
            dynamicFields.innerHTML = "<p>No product details found.</p>";
            return;
        }

        // Dynamically create the form fields based on the category
        let fieldsHtml = '';

        // Common fields (for example, product name, description, etc.)
        
        if (category === 'rtimber') {
            fieldsHtml += `
                           <label for="diameter">Diameter (cm):</label>
                           <input type="number" id="diameter" name="diameter" value="${details.diameter || ''}" required>
                           
                           <label for="price">Price (Rs.):</label>
                           <input type="number" id="price" name="price" value="${details.price || ''}" required>`;

        } else if (category === 'rlumber') {
            fieldsHtml += `
                           
                           <label for="length">Length (cm):</label>
                           <input type="number" id="length" name="length" value="${details.length || ''}" required>
                           
                           <label for="width">Width (cm):</label>
                           <input type="number" id="width" name="width" value="${details.width || ''}" required>
                           
                           <label for="thickness">Thickness (cm):</label>
                           <input type="number" id="thickness" name="thickness" value="${details.thickness || ''}" required>
                           
                           <label for="quantity">Quantity:</label>
                           <input type="number" id="quantity" name="quantity" value="${details.qty || ''}" required>
                           
                           <label for="unitPrice">Unit Price (Rs.):</label>
                           <input type="number" id="unitPrice" name="unitPrice" value="${details.unitPrice || ''}" required>`;

        } else if (category === 'ffurniture') {
            fieldsHtml += `<label for="description">Description:</label>
                           <input type="text" id="description" name="description" value="${details.description || ''}" required>
                           
                           <label for="type">Type:</label>
                           <input type="text" id="type" name="type" value="${details.type || ''}" required>
                           
                           
                           
                           <label for="price">Price (Rs.):</label>
                           <input type="number" id="price" name="price" value="${details.price || ''}" required>`;

        } else if (category === 'ddoorsandwindows') {
            fieldsHtml += `<label for="description">Description:</label>
                           <input type="text" id="description" name="description" value="${details.description || ''}" required>
                           
                           <label for="type">Type:</label>
                           <input type="text" id="type" name="type" value="${details.type || ''}" required>
                           
                          
                           
                           <label for="price">Price (Rs.):</label>
                           <input type="number" id="price" name="price" value="${details.price || ''}" required>`;
        }

        // Add a submit button at the end
        

        // Insert the fields into the dynamic fields container
        dynamicFields.innerHTML = fieldsHtml;
    }
});
