document.addEventListener("DOMContentLoaded", () => {
    // select DOM elements safely after page load
    const currentDate = document.querySelector(".current-date");
    const daysTag = document.querySelector(".days");
    const prevNextIcon = document.querySelectorAll(".icons span");
    
    // Check if required elements exist
    if (!currentDate || !daysTag) {
        console.error("Required calendar elements not found in the DOM. Make sure your HTML includes elements with classes 'current-date' and 'days'.");
        return; // Exit early if elements don't exist
    }

    // getting new date, current year and month
    let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

    // storing full name of all months in array
    const months = ["January", "February", "March", "April", "May", "June", "July",
                  "August", "September", "October", "November", "December"];

    const renderCalendar = () => {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(); // getting first day of month
        let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(); // getting last date of month
        let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(); // getting last day of month
        let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
        let liTag = "";

        // Parse PHP-injected dates if they exist
        const measurementEl = document.getElementById('mDate');
        const deliveryEl = document.getElementById('dDate');
        
        const measurementText = measurementEl ? measurementEl.textContent.trim() : null;
        const deliveryText = deliveryEl ? deliveryEl.textContent.trim() : null;
        
        const measurement = measurementText ? new Date(measurementText) : null;
        const delivery = deliveryText ? new Date(deliveryText) : null;

        // Creating li of previous month last days
        for (let i = firstDayofMonth; i > 0; i--) {
            liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
        }

        // Creating li of all days of current month
        for (let i = 1; i <= lastDateofMonth; i++) {
            // Adding active class to li if the current day, month, and year matched
            let isToday = i === date.getDate() && 
                         currMonth === new Date().getMonth() && 
                         currYear === new Date().getFullYear() ? "active" : "";
            
            let highlightClass = "";

            // Add special classes for measurement and delivery dates if they exist
            if (measurement && 
                currYear === measurement.getFullYear() && 
                currMonth === measurement.getMonth() && 
                i === measurement.getDate()) {
                highlightClass = "measurement-date";
            }

            if (delivery && 
                currYear === delivery.getFullYear() && 
                currMonth === delivery.getMonth() && 
                i === delivery.getDate()) {
                highlightClass += " delivery-date";
            }

            liTag += `<li class="${isToday} ${highlightClass}">${i}</li>`;
        }

        // Creating li of next month first days
        for (let i = lastDayofMonth; i < 6; i++) {
            liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
        }

        // Setting the current month and year text
        currentDate.innerText = `${months[currMonth]} ${currYear}`;
        
        // Adding the calendar days to the DOM
        daysTag.innerHTML = liTag;
    };

    // Initial render of calendar
    renderCalendar();

    // Setting up event listeners for previous and next month navigation
    if (prevNextIcon && prevNextIcon.length > 0) {
        prevNextIcon.forEach(icon => {
            icon.addEventListener("click", () => {
                // If clicked icon is previous icon then decrement current month by 1 else increment it by 1
                currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

                if (currMonth < 0 || currMonth > 11) {
                    // If current month is less than 0 or greater than 11
                    // Creating a new date of current year & month and pass it as date value
                    date = new Date(currYear, currMonth, new Date().getDate());
                    currYear = date.getFullYear(); // Updating current year with new date year
                    currMonth = date.getMonth(); // Updating current month with new date month
                } else {
                    date = new Date(); // Use the current date
                }
                
                renderCalendar(); // Calling renderCalendar function
            });
        });
    }
});