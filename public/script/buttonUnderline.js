export default function initializeButtonUnderline(buttonSelector, underlineId) {
    const buttonUnderline = document.getElementById(underlineId);
    const button = document.querySelector(buttonSelector);

    if (button && buttonUnderline) {
        const updateWidth = () => {
            buttonUnderline.style.width = button.offsetWidth + "px";
        };

        updateWidth(); // Initialization

        // Observe resize changes
        const observer = new ResizeObserver(updateWidth);
        observer.observe(button);

    } else {
        console.error("Button or underline element not found.");
    }
}