let currentCategory = ''; 
let currentProductName = '';
let currentTab = null; 


document.addEventListener('DOMContentLoaded', () => {
    
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

    const submitButton = document.querySelector('.create-order-form button[type="submit"]');
    submitButton.addEventListener('click', (event) => {
        event.preventDefault(); 

        const form = document.getElementById('create-order-form');

        if (form.reportValidity()) {
            
            confirmSubmit(form);
        }
    });
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


    
    function confirmSubmit() {
        const form = document.getElementById('create-order-form');
        const formData = new FormData(form);
        
        const selectCategory = form.querySelector('#product_category').value;
        //const dia = form.querySelector('#diameter').value
        fetch('../../api/createProduct.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product created successfully!');
                
                form.reset();
                document.getElementById('create-order-modal').style.display = 'none';
    
                
                if (selectCategory === 'furniture') {
                    refreshTab('furniture');
                } else if (selectCategory === 'doorsandwindows') {
                    refreshTab('doors-and-windows');
                }
                
                
            } else {
                alert('Failed to create product: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error submitting product:', error);
            alert('An error occurred while submitting the product.');
        });
    }
    
    function refreshTab(tabId) {
        
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';  
        });
        document.getElementById(tabId).style.display = 'block';  
    
        
        fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            
            
            const updatedTabContent = newDoc.querySelector(`#${tabId}`);
            if (updatedTabContent) {
              
                const currentTabContent = document.querySelector(`#${tabId}`);
                if (currentTabContent) {
                    currentTabContent.innerHTML = updatedTabContent.innerHTML;
                }
            }
        });
    }
    

    
    const closeConfirmationPopup = () => {
        confirmationPopup.style.display = 'none';
    };

   
   
   // confirmSubmitButton.addEventListener('click', confirmSubmit);
    //cancelSubmitButton.addEventListener('click', closeConfirmationPopup);
});


function validateForm() {
    const materialType = document.getElementById('material_type').value;
   
    const unitPrice = parseFloat(document.getElementById('unit_price').value.trim());
    //const productImage = document.getElementById('product_image').value;
    const productCategory = document.getElementById('product_category').value.trim();
    const description = document.getElementById('description').value.trim()
    
   //const diameter = document.getElementById('diameter').value.trim();
    

   
    if (materialType === '') {
        alert("Please select a material type.");
        return false;
    }

    if (productCategory === '') {
        alert("Please select a product category.");
        return false;
    }
    /*if (diameter <=0 || !diameter || isNaN(diameter))
    {
        alert("Please enter a valid diameter (a positive number).");
        return false;
    }*/
    
    if (!unitPrice || isNaN(unitPrice) || unitPrice <= 0) {
        alert("Please enter a valid unit price (a positive number).");
        return false;
    }


    
    if (description === '') {
        alert("Description cannot be empty.");
        return false;
    }
    
    
    if (/\d/.test(description)) {
        alert("Description cannot contain numbers.");
        return false;
    }

    return true;
}

const closeModal = document.querySelector('.close-modal');
const modal = document.getElementById('create-timber');

closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});


document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('create-timber-form');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
            
                confirmSubmit2(form);
            
    });
});


function validateTimberForm() {
    const materialType = document.getElementById('material_type').value;
    const diameter = document.getElementById('diameter').value;
    const unitPrice = document.getElementById('unit_price').value;
    const supplierId = document.getElementById('supplierId').value;

    if (materialType === '') {
        alert("Please select a material type.");
        return false;
    }

    if (!diameter || isNaN(diameter)) {
        alert('Please enter a valid diameter.');
        return false;
    }

    if (!unitPrice || isNaN(unitPrice) || parseFloat(unitPrice) <= 0) {
        alert('Please enter a valid unit price.');
        return false;
    }

    if (!supplierId) {
        alert('Please enter a supplier ID.');
        return false;
    }

    return true;
}
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

    
    document.querySelectorAll('.delete-product-btn').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.productId;
            deleteProduct(productId);
        });
    });

    document.querySelectorAll('.delete-timber-btn').forEach(button => {
        button.addEventListener('click', () => {
            const timberId = button.dataset.timberId;
            deleteTimber(timberId);
        });
    });

    document.querySelectorAll('.delete-lumber-btn').forEach(button => {
        button.addEventListener('click', () => {
            const lumberId = button.dataset.lumberId;
            deleteLumber(lumberId);
        });
    });
}
function confirmSubmit2(form) {
    const formData = new FormData(form);

    fetch('../../api/submitTimber.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product successfully created!');
            document.getElementById('create-timber').style.display = 'none';
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
                        
                       
                        
                    });
             
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting the form.');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('create-lumber-form');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        
            confirmSubmit3(form);
        
    });
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


    document.querySelectorAll('.delete-product-btn').forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.dataset.productId;
            deleteProduct(productId);
        });
    });

    document.querySelectorAll('.delete-timber-btn').forEach(button => {
        button.addEventListener('click', () => {
            const timberId = button.dataset.timberId;
            deleteTimber(timberId);
        });
    });

    document.querySelectorAll('.delete-lumber-btn').forEach(button => {
        button.addEventListener('click', () => {
            const lumberId = button.dataset.lumberId;
            deleteLumber(lumberId);
        });
    });
}
function confirmSubmit3(form) {
    const formData = new FormData(form);

    fetch('../../api/submitLumber.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product successfully created!');
            document.getElementById('create-lumber').style.display = 'none';
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
                        
                        
                      
                    });
             
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error submitting the form.');
    });
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
    const editModal = document.getElementById('edit-product-modal');
    const closeModalBtn = editModal.querySelector('.close-modal');
    const dynamicFields = document.getElementById('dynamic-fields');
    const productContainer = document.getElementById('product-section'); // Replace with the parent container of your product cards.

    let currentCategory = null;
    let currentProductName = null;

    // Event delegation for the edit button
    productContainer.addEventListener('click', (event) => {
        const button = event.target.closest('.edit-btn');
        if (button) {
            const productCard = button.closest('.product-card');
            const productName = productCard.dataset.name;
            const productCategory = productCard.id;
            currentCategory = productCategory;
            currentProductName = productName;

            console.log(currentProductName, " ", currentCategory);

            getProductDetails(productCategory, productName)
                .then(productDetails => {
                    dynamicFields.innerHTML = '';  
                    populateEditForm(productDetails, productCategory);
                    editModal.style.display = 'block';
                });
        }
    });

    // Close modal on button click
    closeModalBtn.addEventListener('click', () => {
        editModal.style.display = 'none';
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });

    // Fetch product details
    function getProductDetails(category, productName) {
        return fetch(`../../api/editProducts.php?category=${category}&productName=${productName}`)
            .then(response => response.json())
            .then(data => data)
            .catch(error => {
                console.error('Error fetching product details:', error);
                return {};
            });
    }

    // Populate the edit form
    function populateEditForm(details, category) {
        if (!details || Object.keys(details).length === 0) {
            dynamicFields.innerHTML = "<p>No product details found.</p>";
            return;
        }

        let fieldsHtml = '';
        if (category === 'rtimber') {
            fieldsHtml += `
                <label for="diameter">Diameter (mm):</label>
                <input type="number" id="diameter" name="diameter" value="${details.diameter || ''}" step="0.01" min="100" max="800" required>
                <label for="price">Price (Rs.):</label>
                <input type="number" id="price" name="price" value="${details.price || ''}" min="1" required>`;
        } else if (category === 'rlumber') {
            fieldsHtml += `
                <label for="length">Length (m):</label>
                <input type="number" id="length" name="length" value="${details.length || ''}" step="0.01" min="2.4"  max ="4.8" required>
                <label for="width">Width (mm):</label>
                <input type="number" id="width" name="width" value="${details.width || ''}" step="0.01" min='50' max="300" required>
                <label for="thickness">Thickness (mm):</label>
                <input type="number" id="thickness" name="thickness" value="${details.thickness || ''}" step="0.01" min='12' max="50" required>
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="${details.qty || ''}" min="1" required>
                <label for="unitPrice">Unit Price (Rs.):</label>
                <input type="number" id="unitPrice" name="unitPrice" value="${details.unitPrice || ''}" min="1" required>`;
        } else if (category === 'ffurniture') {
            fieldsHtml += `
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" value="${details.description || ''}" required>
                <label for="type">Type:</label>
                <select name="type">
                    <option value="${details.type}">${details.type}</option>
                    <option value="Jak">Jak</option>
                    <option value="Mahogany">Mahogany</option>
                    <option value="Teak">Teak</option>
                    <option value="Nedum">Nedum</option>
                    <option value="Sooriyamaara">Sooriyamaara</option>
                </select>
                <label for="price">Price (Rs.):</label>
                <input type="number" id="price" name="price" value="${details.price || ''}" min="1" required>`;
        } else if (category === 'ddoorsandwindows') {
            fieldsHtml += `
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" value="${details.description || ''}" required>
                <label for="type">Type:</label>
                <select name="type">
                    <option value="${details.type}">${details.type}</option>
                    <option value="Jak">Jak</option>
                    <option value="Mahogany">Mahogany</option>
                    <option value="Teak">Teak</option>
                    <option value="Nedum">Nedum</option>
                    <option value="Sooriyamaara">Sooriyamaara</option>
                </select>
                <label for="price">Price (Rs.):</label>
                <input type="number" id="price" name="price" value="${details.price || ''}" min="1" required>`;
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
    
        
        document.querySelectorAll('.delete-product-btn').forEach(button => {
            button.addEventListener('click', () => {
                const productId = button.dataset.productId;
                deleteProduct(productId);
            });
        });
    
        document.querySelectorAll('.delete-timber-btn').forEach(button => {
            button.addEventListener('click', () => {
                const timberId = button.dataset.timberId;
                deleteTimber(timberId);
            });
        });
    
        document.querySelectorAll('.delete-lumber-btn').forEach(button => {
            button.addEventListener('click', () => {
                const lumberId = button.dataset.lumberId;
                deleteLumber(lumberId);
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
function deleteTimber(timberId) {
    if (confirm('Are you sure you want to delete this timber?')) {
        fetch('../../api/deleteTimber.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ timberId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Timber deleted successfully.');
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
                        
                        const productElement = document.querySelector(`.product-card[data-name="${timberId}"]`);
                        if (productElement) {
                            productElement.remove();
                        }
                    }); // Reload the page to reflect changes
            } else {
                alert('Error deleting timber: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function deleteLumber(lumberId) {
    if (confirm('Are you sure you want to delete this lumber?')) {
        fetch('../../api/deleteLumber.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ lumberId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Alert the user about successful deletion
                alert('Lumber deleted successfully.');

                // Find and remove the lumber card directly from the DOM
                const productElement = document.querySelector(`.product-card[data-name="${lumberId}"]`);
                if (productElement) {
                    productElement.remove();  // Remove the element
                }
            } else {
                alert('Error deleting lumber: ' + data.message);
            }
        })
        .catch(error => {
            // Handle errors during the fetch
            console.error('Error:', error);
            alert('An error occurred while deleting the lumber.');
        });
    }
}



// Function to show the Create Timber modal
function showTimberModal() {
    document.getElementById('create-timber').style.display = 'block';
}
function showLumberModal() {
    document.getElementById('create-lumber').style.display = 'block';
}
// Close modal functionality (optional: allows the user to close it)
const closeModalButtons = document.querySelectorAll('.close-modal');
closeModalButtons.forEach(button => {
    button.addEventListener('click', function() {
        const modal = button.closest('.modal');
        modal.style.display = 'none';
    });
});

