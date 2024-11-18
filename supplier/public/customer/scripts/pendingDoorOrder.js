const buttonElement = document.getElementById('action-button');
const statusElement = document.getElementById('status');
const buttonAddElement = document.getElementById('add-button');
const buttonUpdateElement = document.getElementById('update-button');


function updateButton() {
    if (statusElement.textContent === 'Confirmed') {
        buttonElement.textContent = 'Contact';
        buttonElement.onclick = function() {
            alert("Contacting support...");
        };

        buttonAddElement.style.display = 'none';
        buttonUpdateElement.textContent = 'Proceed to Process';
        buttonUpdateElement.onclick = function(){
            alert("Proceeding")
        };

    } else if (statusElement.textContent === 'Processing'){
        buttonElement.textContent = 'Track';
        buttonElement.onclick = function() {
            alert("tracking support...");
        };

        buttonUpdateElement.style.display = 'none';
        buttonAddElement.style.display = 'none';
        
    }else {
        buttonElement.textContent = 'Cancel Order';
        buttonElement.onclick = function() {
            alert("Order has been canceled.");
        };
    }
}


updateButton();

// Example: Simulate status change after some event
// setTimeout(() => {
//     statusElement.setAttribute('data-status', 'Confirmed');
//     statusElement.textContent = 'Confirmed';
//     updateButton();
// }, 3000);  // Simulate status change after 3 seconds
