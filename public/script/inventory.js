import initializeButtonUnderline from "./buttonUnderline.js";
let selectedItemId = null;
let page = 1;

document.addEventListener("DOMContentLoaded", function () {
    loadInventory();

    document.querySelectorAll(".page-switcher").forEach((button) => {
        button.addEventListener("click", function () {
            let currentPage = parseInt(
                document.querySelector(".page-text").textContent.split("/")[0],
            );
            let totalPages = parseInt(
                document.querySelector(".page-text").textContent.split("/")[1],
            );

            if (this.textContent === ">" && currentPage < totalPages) {
                loadInventory(currentPage + 1);
            } else if (this.textContent === "<" && currentPage > 1) {
                loadInventory(currentPage - 1);
            }
        });
    });
});

function loadInventory() {
    fetch(`../src/modules/getInventory.php?page=${page}`)
        .then((response) => response.json())
        .then((data) => {
            const inventoryContainer =
                document.querySelector(".block-for-items");
            inventoryContainer.innerHTML = "";

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
                inventoryContainer.appendChild(threeItemsBlock);
            }
            document.querySelector(".page-text").textContent =
                `${data.current_page}/${data.total_pages}`;
        })
        .catch((error) => console.error("Error loading inventory:", error));
}

window.showItemDetails = function (itemId) {
    fetch(`../src/modules/getInventory.php?id=${itemId}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            const itemName = document.querySelector(".big-item-name"),
                itemImage = document.querySelector(".big-item-image"),
                itemDescription = document.querySelector(".item-description"),
                characteristicsDiv = document.querySelector(".big-item-info"),
                itemCount = document.querySelector(".big-item-count");
            console.log(data);

            let bigBlock = document.querySelector(".detailed-description");
            bigBlock.style.display = "flex";

            if (itemName) itemName.textContent = data.name;
            if (itemImage) itemImage.src = data.image_url;
            if (itemDescription) itemDescription.textContent = data.description;
            if (itemCount)
                itemCount.textContent = `${data.quantity}/${data.quantity}`;

            if (characteristicsDiv) {
                characteristicsDiv.innerHTML = "";
                Object.entries(data).forEach(([key, value]) => {
                    if (
                        ![
                            "id",
                            "name",
                            "description",
                            "image_url",
                            "quantity",
                            "price",
                        ].includes(key) &&
                        value != 0
                    ) {
                        let characteristicName =
                            key.replace("_", " ").charAt(0).toUpperCase() +
                            key.slice(1);
                        let p = document.createElement("p");
                        p.className = "introduction-text buff-info";
                        p.textContent =
                            value > 0
                                ? `+${value} ${characteristicName}`
                                : `${value} ${characteristicName}`;
                        characteristicsDiv.appendChild(p);
                    }
                });
            }
            setTimeout(() => {
                initializeButtonUnderline(".cyber-button", "sign-up-underline");
            }, 0);
            selectedItemId = data.id;
        })
        .catch((error) => console.error("Error:", error));
};
