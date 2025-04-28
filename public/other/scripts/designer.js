let orders = [];
let currentOrder = null;
let currentItem = null;

async function loadChatMessages(orderId, itemId) {
    try {
        const response = await fetch('../../config/customer/get_chat_messages.php', {
            method: 'POST',
            body: JSON.stringify({ orderId, itemId }), // Send as JSON
            headers: { 'Content-Type': 'application/json' }
        });
        const messages = await response.json();
        //console.log(sender)
        // Populate the chat UI with existing messages
        const chatMessages = document.getElementById('chatMessages');
       
        chatMessages.innerHTML = messages.map(message => {
            const sender = message.senderType === 'designer' ? 'You' : 'Customer';
            console.log(sender)
            if (message.messageType === 'image') {
                return `
                    <div class="message ${sender}">
                        <p><strong>${sender}:</strong><img src="${message.messageContent}" alt="Sent image" style="width:150px; border-radius: 8px;" />
                    </div>
                `;
            } else {
                return `
                    <div class="message ${sender}">
                       <p><strong>${sender}:</strong>  ${message.messageContent}
                    </div>
                `;
            }
        }).join('');

        // Scroll to the bottom of the chat
        chatMessages.scrollTop = chatMessages.scrollHeight;
    } catch (error) {
        console.error('Failed to load chat messages:', error);
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const res = await fetch('../../config/customer/get_designer_orders.php');
        const data = await res.json();
        if (Array.isArray(data)) {
            orders = data.map((order, index) => ({ id: index + 1, ...order }));
            initializeOrders();
        } else {
            console.error('Invalid response', data);
        }
    } catch (err) {
        console.error('Failed to fetch orders:', err);
    }

    // Attach enter key listener only after DOM is fully loaded
    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    } else {
        console.error('messageInput element not found!');
    }
});

function initializeOrders() {
    const ordersList = document.getElementById('ordersList');
    if (!ordersList) return;

    ordersList.innerHTML = orders.map(order => `
        <div class="order-item" onclick="selectOrder(${order.id})">
            <h3>${order.orderId}</h3>
            


            
        </div>
    `).join('');
}

function selectOrder(orderId) {
    currentOrder = orders.find(o => o.id === orderId);
    const ordersList = document.getElementById('ordersList');
    ordersList.innerHTML = `
        <button class="back-button" onclick="initializeOrders()">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </button>
        <h4>Order ${currentOrder.orderId} Items</h4>
        ${currentOrder.items.map((item, index) => `
            <div class="order-item" onclick="selectItem(${index})">
                <h5>${item.label} (Item ID: ${item.itemId})</h5>
            </div>
        `).join('')}
    `;
}

function selectItem(itemIndex) {
    currentItem = currentOrder.items[itemIndex];
    const chatHeader = document.getElementById('customerName');
    chatHeader.textContent = `Chat about ${currentItem.label}`;
    
    // Update the orderId and itemId displays
    document.getElementById('orderId').textContent = currentOrder.orderId;
    document.getElementById('itemId').textContent = currentItem.itemId;
    
    // Load chat messages specific to the selected item
    loadChatMessages(currentOrder.orderId, currentItem.itemId);
}

// Send a new message to the backend
async function sendMessage(userId) {
    // Check if an order and item are selected
    if (!currentOrder || !currentItem) {
        alert('Please select an order and item first.');
        return;
    }

    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    console.log(currentOrder.orderId)
    console.log(currentItem.itemId)
    // Validate message
    if (message) {
        try {
            const response = await fetch('../../config/customer/send_message.php', {
                method: 'POST',
                body: JSON.stringify({
                    message,
                    orderId: currentOrder.orderId,
                    itemId: currentItem.itemId,
                    userId
                }),
                headers: { 'Content-Type': 'application/json' }
            });

            const result = await response.json();
            if (result.status === 'success') {
                input.value = '';  // Clear the input after sending
                
                // Reload chat messages for the correct order and item
                loadChatMessages(currentOrder.orderId, currentItem.itemId);
            } else {
                console.error('Failed to send message:', result.message);
            }
        } catch (error) {
            console.error('Failed to send message:', error);
        }
    }
}

function handleFileUpload(event) {
    // Check if an order and item are selected
    if (!currentOrder || !currentItem) {
        alert('Please select an order and item first.');
        return;
    }

    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = async function(e) {
            // Display the image in chat
            const chatMessages = document.getElementById('chatMessages');
            const messageElement = document.createElement('div');
            const senderType = 'designer'; 
            messageElement.className = 'message sent';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            messageElement.appendChild(img);
            chatMessages.appendChild(messageElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
           
            
            // Send the image to the server
            const formData = new FormData();
            formData.append('image', file);
            formData.append('orderId', currentOrder.orderId);
            formData.append('itemId', currentItem.itemId);
            formData.append('senderType', senderType);
            
            try {
                const response = await fetch('../../config/customer/uploadImage.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    console.log('Image uploaded successfully');
                } else {
                    console.error('Failed to upload image:', result.message);
                }
            } catch (error) {
                console.error('Error uploading image:', error);
            }
        };
        reader.readAsDataURL(file);
    }
}

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}// Update the previewImage function to store the file for later upload
let fileToUpload = null;

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Store the file for later upload
        fileToUpload = file;
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImage = document.getElementById('previewImage');
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        // Enable the update button
        document.getElementById('updateImageBtn').disabled = false;
    }
}

// Add this function to handle the image upload when the Update button is clicked
function uploadCustomizedImage() {
    // Check if we have a file to upload
    if (!fileToUpload || !currentOrder || !currentItem) {
        alert('Please select an image and ensure an order/item is selected.');
        return;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('image', fileToUpload);
    formData.append('orderId', currentOrder.orderId);
    formData.append('itemId', currentItem.itemId);
    
    // Send to server
    fetch('../../config/customer/upload_customized_image.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert('Image uploaded successfully!');
            document.getElementById('updateImageBtn').disabled = true;
        } else {
            alert('Failed to upload image: ' + result.message);
        }
    })
    .catch(error => {
        console.error('Error uploading image:', error);
        alert('Error uploading image. Please try again.');
    });
}