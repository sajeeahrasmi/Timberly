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
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', () => showPopup(card.dataset.name));
    });

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
    const unitPrice = document.getElementById('unit_price').value;
    const productImage = document.getElementById('product_image').files.length;

    if (!materialType) {
        alert('Please select a material type.');
        return false;
    }

    if (materialType === 'other') {
        const customMaterial = document.getElementById('custom_material_type').value;
        if (!customMaterial) {
            alert('Please specify the custom material.');
            return false;
        }
    }

    if (!unitPrice || unitPrice <= 0) {
        alert('Please enter a valid unit price.');
        return false;
    }

    if (productImage === 0) {
        alert('Please upload a product image.');
        return false;
    }

    return true; // All checks passed, allow form submission
}

// Check Custom Material Function
function checkCustomMaterial(select) {
    const customMaterialLabel = document.getElementById('custom_material_label');
    const customMaterialInput = document.getElementById('custom_material_type');
    if (select.value === 'other') {
        customMaterialLabel.style.display = 'block';
        customMaterialInput.style.display = 'block';
    } else {
        customMaterialLabel.style.display = 'none';
        customMaterialInput.style.display = 'none';
    }
}
