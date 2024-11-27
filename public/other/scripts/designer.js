
let orders = [];

document.addEventListener('DOMContentLoaded', () => {
     orders = [
        {
            id: 1,
            customerName: "Amal Perera",
            items: ["Mahogany Door", "Mahogany Window"],
        },
        {
            id: 2,
            customerName: "Simal Nimal",
            items: ["Teak Table"],
        },
    ];

    initializeOrders();
});

       

        let currentOrder = null;
        let currentItem = null;

        async function initializeOrders() {

            const ordersList = document.getElementById('ordersList');
            ordersList.innerHTML = orders.map(order => `
                <div class="order-item" onclick="selectOrder(${order.id})">
                    <h3>${order.customerName}</h3>
                    <p>Items: ${order.items.join(', ')}</p>
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
                <h4>${currentOrder.customerName}'s Items</h4>
                ${currentOrder.items.map((item, index) => `
                    <div class="order-item" onclick="selectItem(${index})">
                        <h5>${item}</h5>
                    </div>
                `).join('')}
            `;
        }

        function selectItem(itemIndex) {
            currentItem = currentOrder.items[itemIndex];
            const chatHeader = document.getElementById('customerName');
            chatHeader.textContent = `Chat about ${currentItem}`;
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.innerHTML = `
                <div class="order-details">
                    <h3>Item Details</h3>
                    <p>Customer: ${currentOrder.customerName}</p>
                    <p>Item: ${currentItem}</p>
                </div>
            `;
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            if (message) {
                const chatMessages = document.getElementById('chatMessages');
                const messageElement = document.createElement('div');
                messageElement.className = 'message sent';
                messageElement.textContent = message;
                chatMessages.appendChild(messageElement);
                input.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
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

        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // initializeOrders();
