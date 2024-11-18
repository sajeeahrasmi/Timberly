function openChat(productName) {
    const chatHeader = document.getElementById('chat-header');
    const chatContent = document.getElementById('chat-content');

    chatHeader.innerText = `Chat about ${productName}`;
    chatContent.innerHTML = `<p>Starting conversation about ${productName}...</p>`;
}

function sendMessage() {
    const chatContent = document.getElementById('chat-content');
    const chatMessage = document.getElementById('chat-message');

    if (chatMessage.value.trim() !== '') {
        chatContent.innerHTML += `<p><strong>You:</strong> ${chatMessage.value}</p>`;
        chatMessage.value = '';
        chatContent.scrollTop = chatContent.scrollHeight;
    }
}

function uploadImage(event) {
    const chatContent = document.getElementById('chat-content');
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            chatContent.innerHTML += `<p><strong>You:</strong> <img src="${e.target.result}" alt="Uploaded Image" style="width:150px; border-radius: 8px;"></p>`;
            chatContent.scrollTop = chatContent.scrollHeight;
        };
        reader.readAsDataURL(file);
    }
}
