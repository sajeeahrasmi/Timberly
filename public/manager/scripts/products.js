let currentCategory = ''; 
let currentProductName = '';
document.addEventListener('DOMContentLoaded', () => {
    // Tab switching 
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
        console.log('Close button clicked'); 
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    const submitButton = document.querySelector('.create-order-form button[type="submit1"]');
    //const confirmationPopup = document.getElementById('confirmation-popup');
    //const confirmSubmitButton = document.getElementById('confirm-submit');
    const cancelSubmitButton = document.getElementById('cancel-submit');
    const createOrderModal = document.getElementById('create-order-modal');

    //  open the confirmation popup
    /*const openConfirmationPopup = (event) => {
        event.preventDefault(); 
        if (validateForm()) { 
            confirmationPopup.style.display = 'block';
        }
    };
*/
    //  handle confirmation
    function confirmSubmit() {
        const form = document.getElementById('create-order-form');
        const formData = new FormData(form); 
    
        fetch('../../api/createProduct.php', {
            method: 'POST',
            body: formData  
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product created successfully!');
                
                document.getElementById('create-order-modal').style.display = 'none';
                fetch(window.location.href)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, 'text/html');
                    
                    
                    if (currentTab) {
                        const newTabContent = newDoc.querySelector(`#${currentTab.id}`);
                        if (newTabContent) {
                            currentTab.innerHTML = newTabContent.innerHTML;
                        }
                    }
                    
                    const productElement = document.getElementById("product-" + productId);
                    if (productElement) {
                        productElement.remove();
                    }
                });
            } else {
                alert('Failed to create product: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error submitting product:', error);
            alert('An error occurred while submitting the product.');
        });
    }
    
    

    
    const closeConfirmationPopup = () => {
        confirmationPopup.style.display = 'none';
    };

   
    submitButton.addEventListener('click', confirmSubmit);
   // confirmSubmitButton.addEventListener('click', confirmSubmit);
    //cancelSubmitButton.addEventListener('click', closeConfirmationPopup);
});


function validateForm() {
    const materialType = document.getElementById('material_type').value;
   
    const unitPrice = parseFloat(document.getElementById('unit_price').value);
    //const productImage = document.getElementById('product_image').value;
    const productCategory = document.getElementById('product_category').value;
    const productDescription = document.getElementById('description').value

    if (materialType === '') {
        alert('Please select a material type.');
        return false;
    }

    if (materialType === 'other') {
        alert('Please select a material type');
        return false;
    }

    if (unitPrice <= 0) {
        alert('Unit price must be greater than 0.');
        return false;
    }

    /*if (!productImage) {
        alert('Please upload a product image.');
        return false;
    }*/

    if (productCategory === '') {
        alert('Please select a product category.');
        return false;
    }

    if (productDescription === '') {
        alert('Please Enter a description.');
        return false;
    }

    return true;
}


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
            //console.log(productName, " " , productCategory) 
            currentCategory = productCategory;
            currentProductName = productName;
            console.log(currentProductName, " " , currentCategory) 
            getProductDetails(productCategory, productName)
                .then(productDetails => {
                    
                    dynamicFields.innerHTML = '';  
                    populateEditForm(productDetails, productCategory); 
    
                    
                    editModal.style.display = 'block';
                });
        });
    });
    

    
    closeModalBtn.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });

   
    function getProductDetails(category, productName) {
        return fetch(`../../api/editProducts.php?category=${category}&productName=${productName}`)
            .then(response => response.json())
            .then(data => {
                return data;  
            })
            .catch(error => {
                console.error('Error fetching product details:', error);
                return {};  
            });
    }
   

    
    function populateEditForm(details, category) {
        if (!details || Object.keys(details).length === 0) {
           
            dynamicFields.innerHTML = "<p>No product details found.</p>";
            return;
        }

        
        let fieldsHtml = '';

        
        
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
                           
                                    Type:
                    <select name="type">
                        <option value="Jak">${details.type}</option>    
                        <option value="Jak">Jak</option>
                        <option value="Mahogany">Mahogany</option>
                        <option value="Teak">Teak</option>
                        <option value="Nedum">Nedum</option>
                        <option value="Sooriyam">Sooriyam</option>
                    </select>
                    
                           
                           
                           
                           <label for="price">Price (Rs.):</label>
                           <input type="number" id="price" name="price" value="${details.price || ''}" required>`;

        } else if (category === 'ddoorsandwindows') {
            fieldsHtml += `<label for="description">Description:</label>
                           <input type="text" id="description" name="description" value="${details.description || ''}" required>
                           
                                 
                           Type:
                           <select name="type">
                               
                            <option value="Jak">${details.type}</option>
                               <option value="Jak">Jak</option>
                               <option value="Mahogany">Mahogany</option>
                               <option value="Teak">Teak</option>
                               <option value="Nedum">Nedum</option>
                               <option value="Sooriyam">Sooriyam</option>
                           </select>
                           
                           
                          
                           
                           <label for="price">Price (Rs.):</label>
                           <input type="number" id="price" name="price" value="${details.price || ''}" required>`;
        }

        
        

        
        dynamicFields.innerHTML = fieldsHtml;
    }
   

    

   
    
    const editForm = document.getElementById('edit-product-form');
    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();

       
        const formData = new FormData(editForm);
        
       
        formData.append('category', currentCategory);
        formData.append('productName', currentProductName);
        console.log(currentProductName, " " , currentCategory) 
        try {
            const response = await fetch('../../api/editUpdateProducts.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert('Product updated successfully!');
                document.getElementById('edit-product-modal').style.display = 'none';
                const currentTab = document.querySelector('.tab-content.active');
                
                
                fetch(window.location.href)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        
                       
                        if (currentTab) {
                            const newTabContent = newDoc.querySelector(`#${currentTab.id}`);
                            if (newTabContent) {
                                currentTab.innerHTML = newTabContent.innerHTML;
                            }
                        }
                        
                        
                        attachEventListeners();
                    });
            } else {
                alert('Failed to update product: ' + result.message);
            }
        } catch (error) {
            console.error('Error updating product:', error);
            alert('An error occurred while updating the product');
        }
    });

    
    function attachEventListeners() {
        
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const productCard = button.closest('.product-card');
                const productName = productCard.dataset.name;
                const productCategory = productCard.id;
                currentCategory = productCategory;
                currentProductName = productName;

                getProductDetails(productCategory, productName)
                    .then(productDetails => {
                        dynamicFields.innerHTML = '';
                        populateEditForm(productDetails, productCategory);
                        document.getElementById('edit-product-modal').style.display = 'block';
                    });
            });
        });

        
    }
    
});

function deleteProduct(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
        fetch("../../api/deleteProduct.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "productId=" + encodeURIComponent(productId)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                
                const currentTab = document.querySelector('.tab-content.active');
                
                
                fetch(window.location.href)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        
                        
                        if (currentTab) {
                            const newTabContent = newDoc.querySelector(`#${currentTab.id}`);
                            if (newTabContent) {
                                currentTab.innerHTML = newTabContent.innerHTML;
                            }
                        }
                        
                        const productElement = document.getElementById("product-" + productId);
                        if (productElement) {
                            productElement.remove();
                        }
                    });
            }
        })
        .catch(() => {
            alert("Error occurred during deletion");
        });
    }
}


