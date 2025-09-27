import initializeButtonUnderline from "./buttonUnderline.js";
let selectedItemId = null;
let originalPrice = 0; // Variable to store the original price

document.addEventListener("DOMContentLoaded", function () {
    const productItems = document.querySelectorAll(".item-block");
    const countButtons = document.querySelectorAll(".count-button");
    const itemCountDisplay = document.querySelector(".big-item-count");
    const priceContent = document.querySelector(".big-item-price");

    productItems.forEach((item) => {
        item.addEventListener("click", function () {
            // Extract item ID from the onclick attribute
            const itemId = this.getAttribute("onclick").match(
                /showItemDetails\((\d+)\)/,
            )[1];
            showItemDetails(itemId);
        });
    });

    // Function to fetch and display item details
    window.showItemDetails = function (itemId) {
        fetch(`../src/modules/getItemInfo.php?id=${itemId}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                const itemName = document.querySelector(".big-item-name"),
                    itemPrice = document.querySelector(".big-item-price"),
                    itemImage = document.querySelector(".big-item-image"),
                    itemDescription =
                        document.querySelector(".item-description"),
                    characteristicsDiv =
                        document.querySelector(".big-item-info"),
                    itemCount = document.querySelector(".big-item-count"),
                    buyButton = document.querySelector(".shop-button");

                let bigBlock = document.querySelector(".detailed-description");
                bigBlock.style.display = "flex";

                if (buyButton) {
                    buyButton.setAttribute("data-item-id", data.id);
                }

                if (itemName) itemName.textContent = data.name;
                if (itemPrice) {
                    itemPrice.textContent = data.price; // Set the price
                    originalPrice = parseFloat(data.price); // Store the original price
                }
                if (itemImage) itemImage.src = data.image_url;
                if (itemDescription)
                    itemDescription.textContent = data.description;
                if (itemCount) itemCount.textContent = `1/${data.quantity}`;

                if (characteristicsDiv) {
                    characteristicsDiv.innerHTML = ""; // Clear existing characteristics
                    Object.keys(data).forEach((key) => {
                        if (
                            ![
                                "id",
                                "name",
                                "description",
                                "price",
                                "category",
                                "image_url",
                                "quantity",
                            ].includes(key) &&
                            data[key] != 0
                        ) {
                            let characteristicName =
                                key.replace("_", " ").charAt(0).toUpperCase() +
                                key.slice(1);
                            let p = document.createElement("p");
                            p.className = "introduction-text buff-info";
                            p.textContent =
                                data[key] > 0
                                    ? `+${data[key]} ${characteristicName}`
                                    : `${data[key]} ${characteristicName}`;
                            characteristicsDiv.appendChild(p);
                        }
                    });
                }
                setTimeout(() => {
                    // Use setTimeout to ensure DOM update
                    initializeButtonUnderline(
                        ".cyber-button",
                        "sign-up-underline",
                    );
                }, 0);
                selectedItemId = data.id;
            })
            .catch((error) => console.error("Error:", error));
    };

    countButtons.forEach((button) => {
        button.addEventListener("click", function () {
            if (!itemCountDisplay || !priceContent) return;

            const [currentCountText, maxCountText] =
                itemCountDisplay.textContent.split("/");
            let currentCount = parseInt(currentCountText) || 1;
            const maxCount = parseInt(maxCountText) || 1;

            const change = this.textContent === "+" ? 1 : -1;
            const newCount = Math.max(
                1,
                Math.min(maxCount, currentCount + change),
            );

            // Calculate price based on the new count
            const itemPrice = originalPrice * newCount;
            priceContent.textContent = itemPrice.toFixed(2); // Display price with 2 decimal places
            itemCountDisplay.textContent = `${newCount}/${maxCount}`;
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    loadItems(1); // Load the first page of items

    document.querySelectorAll(".page-switcher").forEach((button) => {
        button.addEventListener("click", function () {
            let currentPage = parseInt(
                document.querySelector(".page-text").textContent.split("/")[0],
            );
            let totalPages = parseInt(
                document.querySelector(".page-text").textContent.split("/")[1],
            );

            if (this.textContent === ">" && currentPage < totalPages) {
                loadItems(currentPage + 1);
            } else if (this.textContent === "<" && currentPage > 1) {
                loadItems(currentPage - 1);
            }
        });
    });
});

function loadItems(page) {
    fetch(`../src/modules/getAllItems.php?page=${page}`)
        .then((response) => response.json())
        .then((data) => {
            const itemsContainer = document.querySelector(".block-for-items");
            itemsContainer.innerHTML = ""; // Clear the container before adding new items

            // Create three "three-items" blocks
            for (let i = 0; i < 3; i++) {
                let threeItemsBlock = document.createElement("div");
                threeItemsBlock.classList.add("three-items");

                for (let j = 0; j < 3; j++) {
                    let index = i * 3 + j;
                    if (data.items[index]) {
                        let item = data.items[index];
                        let itemHtml = `
                            <div class="full-item-block">
                                <div class="item-block" onclick="showItemDetails(${item.id})"> 
                                    <div class="underline" id="item-underline"></div>
                                    <p class="text-for-block item-count">${item.quantity}/${item.quantity}</p>
                                    <img class = "background-image" src="${item.image_url}" alt="Item Image">
                                </div>
                                <p class="text-for-block item-name">${item.name}</p>
                            </div>
                        `;
                        threeItemsBlock.innerHTML += itemHtml;
                    }
                }
                itemsContainer.appendChild(threeItemsBlock);
            }

            // Update the page number text
            document.querySelector(".page-text").textContent =
                `${data.current_page}/${data.total_pages}`;
        })
        .catch((error) => console.error("Error loading data:", error));
}

document.addEventListener("DOMContentLoaded", () => {
    const buyButton = document.querySelector(".shop-button");

    buyButton.addEventListener("click", async () => {
        if (!selectedItemId) {
            alert("Please select an item before purchasing.");
            return;
        }

        const itemName = document.querySelector(".big-item-name").textContent;
        const itemPrice = parseFloat(
            document.querySelector(".big-item-price").textContent,
        );
        const quantityElement = document.querySelector(".big-item-count");
        const quantity = quantityElement
            ? parseInt(quantityElement.textContent.split("/")[0]) || 1
            : 1;
        const unitPrice = originalPrice;
        const totalPrice = unitPrice * quantity;

        const response = await fetch("/webspace/CTS/modules/buy.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                item_id: selectedItemId,
                item_name: itemName,
                item_price: unitPrice,
                quantity: quantity,
            }),
        });

        try {
            const data = await response.json();
            if (data.success) {
                alert("Purchase successful!");
                location.reload();
            } else {
                alert("Error: " + data.error);
            }
        } catch (error) {
            console.error("Invalid JSON response:", error);
        }
    });
});
