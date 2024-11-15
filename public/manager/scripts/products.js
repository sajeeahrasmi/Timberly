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
        event.preventDefault(); // Prevent the default form submission
        if (validateForm()) { // Validate the form first
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