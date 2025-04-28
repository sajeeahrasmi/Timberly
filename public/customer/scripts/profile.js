async function updateProfile(userId){
    const email = document.getElementById("email").value; 
    const phone = document.getElementById("phone").value; 
    const address = document.getElementById("address").value; 

    if(!email || !phone || !address){
        alert("Please fill out the fields");
        return;
    }
   

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address!");
    } 

    
    
    try{
        const response = await fetch(`../../config/customer/profile.php?action=updateProfile&userId=${userId}&email=${email}&address=${address}&phone=${phone}`);
        const data = await response.json();

        if(data.success){
            alert("Successfully updated the details");
            location.reload();
            
        }else{
            alert("Couldnt update.");
        }
    }catch (error){
            console.log("Error: ", error);
    }
}