function openChat(productName, productId) {
    const chatHeader = document.getElementById('chat-header');
    const chatContent = document.getElementById('chat-content');

    // Fetch existing chat messages from the backend
    fetch('../../config/customer/savechat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            productId: productId,
            productName: productName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Chat loaded successfully!');
            // Display existing messages in the chat content
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    const sender = msg.senderType === 'customer' ? 'You' : 'Designer';
                    const messageContent = msg.messageType === 'text' 
                        ? msg.message 
                        : `<img src="${msg.message}" alt="Image" style="width:150px; border-radius: 8px;">`;

                    chatContent.innerHTML += `
                        <p><strong>${sender}:</strong> ${messageContent}</p>
                    `;
                });
                chatContent.scrollTop = chatContent.scrollHeight; // Scroll to the bottom of the chat
            } else {
                chatContent.innerHTML += `<p>No messages yet. Start the conversation!</p>`;
            }
        } else {
            console.error('Error loading chat:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });

    // Update the chat header
    chatHeader.innerText = `Chat about ItemID : ${productName}`;
    chatContent.innerHTML = `<p>Starting conversation about ItemID ${productName}...</p>`;
}


function sendMessage(itemId, orderId) {
    const chatContent = document.getElementById('chat-content');
    const chatMessage = document.getElementById('chat-message');
   // const sessionId = document.getElementById('designerchat-session-id').value;

    const message = chatMessage.value.trim();

    if (message !== '') {
        chatContent.innerHTML += `<p><strong>You:</strong> ${message}</p>`;
        chatMessage.value = '';
        chatContent.scrollTop = chatContent.scrollHeight;

        fetch('../../config/customer/savemessage.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                itemId: itemId,
                orderId: orderId,
                senderType: 'customer',
                message: message,
                messageType: 'text'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Message not saved:', data.error);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
    }
}


function uploadImage(event) {
    const chatContent = document.getElementById('chat-content');
    const fileInput = event.target;
    const file = event.target.files[0];
    const itemId = fileInput.dataset.itemId;
    const orderId = fileInput.dataset.orderId;
    const senderType = 'customer'; 
    if (file && file.type.startsWith('image/')) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('itemId', itemId);
        formData.append('orderId', orderId);
        formData.append('senderType', senderType);


        fetch('../../config/customer/uploadImage.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status == 'success') {
                const imagePath = data.imageUrl; // Full URL or relative path
                chatContent.innerHTML += `<p><strong>You:</strong> <img src="${imagePath}" alt="Uploaded Image" style="width:150px; border-radius: 8px;"></p>`;
                chatContent.scrollTop = chatContent.scrollHeight;
            } else {
                console.error('Upload failed:', data.error);
            }
        })
        .catch(error => {
            console.error('Error uploading image:', error);
        });
    }
}
