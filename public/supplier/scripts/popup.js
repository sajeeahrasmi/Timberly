const popupTriggers = document.querySelectorAll(".popup-trigger")
const popups = document.querySelectorAll(".popup")

const showPopup = (e) => {
    popups.forEach((popup) => hidePopup(popup))
    e.classList.add("show")
}

const hidePopup = (e) => {
    e.classList.remove("show")
}

popupTriggers.forEach((popupTrigger) => {
    popupTrigger.addEventListener("click", () => {
        const popupId = popupTrigger.getAttribute("data-popup-id")
        if (!popupId) {
            alert("please enter a popup id")
            return;
        }
        const popup = document.getElementById(popupId);
        if (!popup) {
            alert("please enter a valid popup id")
            return;
        }
        showPopup(popup)
    })
})

popups.forEach((popup) => {
    popup.addEventListener("click", () => {
        hidePopup(popup)
    })
    const popupCloseButton = popup.querySelector(".popup-close-button")
    const popupWrapper = popup.querySelector(".popup-wrapper")

    popupCloseButton.addEventListener("click", () => {
        hidePopup(popup)
    })

    popupWrapper.addEventListener("click", (e) => {
        e.stopPropagation()
    })
})
