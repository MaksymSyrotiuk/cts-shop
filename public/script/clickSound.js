    const clickSound = new Audio("./sounds/Click.wav"); 
    document.addEventListener("click", () => {
        clickSound.play();
    });