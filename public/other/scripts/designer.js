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

        // Populate the chat UI with existing messages
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.innerHTML = messages.map(message => {
            if (message.messageType === 'image') {
                return `
                    <div class="message ${message.senderType}">
                        <img src="${message.messageContent}" alt="Sent image" style="max-width: 200px; border-radius: 8px;" />
                    </div>
                `;
            } else {
                return `
                    <div class="message ${message.senderType}">
                        <p>${message.messageContent}</p>
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
    
    // Load chat messages specific to the selected item
    loadChatMessages(currentOrder.orderId, currentItem.itemId);

    const chatMessages = document.getElementById('chatMessages');
    document.getElementById('orderId').textContent = currentOrder.orderId;
    document.getElementById('itemId').textContent = currentItem.itemId;

    // Display item details in the chat header
    chatMessages.innerHTML = `
        <div class="order-details">
            <h3>Item Details</h3>
            <p>Customer: ${currentOrder.orderId}</p>
            <p>Item: ${currentItem.label}</p>
            <p>Item ID: ${currentItem.itemId}</p>
        </div>
    `;
}


// Send a new message to the backend
async function sendMessage(userId) {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    // Validate message
    if (message) {
        try {
            const response = await fetch('../../config/customer/send_message.php', {
                method: 'POST',
                body: JSON.stringify({
                    message,
                    orderId: currentOrder.orderId, // Always use currentOrder and currentItem
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
            }
        } catch (error) {
            console.error('Failed to send message:', error);
        }
    }
}

function handleFileUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const chatMessages = document.getElementById('chatMessages');
            const messageElement = document.createElement('div');
            messageElement.className = 'message sent';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            messageElement.appendChild(img);
            chatMessages.appendChild(messageElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        };
        reader.readAsDataURL(file);
    }
}