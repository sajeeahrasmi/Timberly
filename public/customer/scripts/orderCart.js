document.addEventListener('DOMContentLoaded', function() {
    
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            updateItemQuantity(this);
        });
    });

    const removeButtons = document.querySelectorAll('.remove-button');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            removeCartItem(this);
        });
    });

    const selectCheckboxes = document.querySelectorAll('.select-to-order');
    selectCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectToOrder(this);
        });
    });

    const orderNowBtn = document.getElementById('order-now-btn');
    if (orderNowBtn) {
        orderNowBtn.addEventListener('click', processOrder);
    }
});

async function updateItemQuantity(input) {
    const cartId = input.closest('.cart-item').dataset.cartId;
    const quantity = input.value;
    
    if (quantity < 1) {
        alert("Quantity should be at least 1")
        input.value = 1;
        return;
    }

    try{
        const response = await fetch(`../../config/customer/orderCart.php?action=updateQuantity&cartId=${cartId}&qty=${quantity}`);
        const data = await response.json();

        if(data.success){
            // alert('Quantity updated!');

        }else{
            alert('Failed to update selection: ' + data.message);
            
        }   

    }catch (error){
        console.error('Error:', error);
        alert('An error occurred while updating the quantity');
        
    }


}


async function removeCartItem(button) {
    if (!confirm('Are you sure you want to remove this item from your cart?')) {
        return;
    }

    const cartItem = button.closest('.cart-item');
    const cartId = cartItem.dataset.cartId;

    try{
        const response = await fetch(`../../config/customer/orderCart.php?action=removeItem&cartId=${cartId}`);
        const data = await response.json();

        if(data.success){
            alert('Removed item!');

        }else{
            alert('Failed to remove item: ' + data.message);
           
        }   

    }catch (error){
        console.error('Error:', error);
        alert('An error occurred while removing the item');
        
    }

}


async function updateSelectToOrder(checkbox) {
    const cartItem = checkbox.closest('.cart-item');
    const cartId = cartItem.dataset.cartId;
    const selectToOrder = checkbox.checked ? 'yes' : 'no';

    try{
        const response = await fetch(`../../config/customer/orderCart.php?action=updateSelectToOrder&cartId=${cartId}&selectToOrder=${selectToOrder}`);
        const data = await response.json();

        if(data.success){
            // alert('Checked to order!');

        }else{
            alert('Failed to update selection: ' + data.message);
            checkbox.checked = !checkbox.checked; 
        }   

    }catch (error){
        console.error('Error:', error);
        alert('An error occurred while updating the selection');
        checkbox.checked = !checkbox.checked; 
    }
    
}

async  function clearCart(userId) {
    if (!confirm('Are you sure you want to clear your entire cart?')) {
        return;
    }

    try{
        const response = await fetch(`../../config/customer/orderCart.php?action=clearCart&userId=${userId}`);
        const data = await response.json();

        if(data.success){
            alert('Cart cleared!');

        }else{
            alert('Failed to clear cart: ' + data.message);
           
        }   

    }catch (error){
        console.error('Error:', error);
        alert('An error occurred while clearing the cart');
        
    }
}

function processOrder() {
    // Check if any items are selected
    const selectedItems = document.querySelectorAll('.select-to-order:checked');
    
    if (selectedItems.length === 0) {
        alert('Please select at least one item to order');
        return;
    }
    
    // window.location.href = 'http://localhost/Timberly/public/customer/payment-details.php?orderId=${orderId}';
}