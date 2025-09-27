document.addEventListener("DOMContentLoaded", function () {
    loadTransactions(1); // Load the first page of transactions

    document
        .querySelectorAll(".transaction-pagination .page-switcher")
        .forEach((button) => {
            button.addEventListener("click", function () {
                let currentPage = parseInt(
                    document
                        .querySelector(".transaction-pagination .page-text")
                        .textContent.split("/")[0],
                );
                let totalPages = parseInt(
                    document
                        .querySelector(".transaction-pagination .page-text")
                        .textContent.split("/")[1],
                );

                if (this.textContent === ">" && currentPage < totalPages) {
                    loadTransactions(currentPage + 1);
                } else if (this.textContent === "<" && currentPage > 1) {
                    loadTransactions(currentPage - 1);
                }
            });
        });
});

function loadTransactions(page) {
    fetch(`../src/modules/getTransactions.php?page=${page}`)
        .then((response) => response.json())
        .then((data) => {
            const transactionsContainer = document.querySelector(".shop-block");
            transactionsContainer.innerHTML = ""; // Clear the container before adding new elements

            // Limit the data to the first 9 transactions (for the current page)
            const transactionsToShow = data.transactions; // Assuming the server sends a 'transactions' array

            transactionsToShow.forEach((transaction) => {
                let transactionBlock = document.createElement("div");
                transactionBlock.classList.add("transaction-block");

                transactionBlock.innerHTML = `
                    <div class="item-block">
                        <div class="underline" id="item-underline"></div>
                        <img src="${transaction.image_url}" alt="Item Image">
                    </div>
                    <div class="transaction-info">
                        <h2 class="transaction-item-name">${transaction.item_name} (${transaction.item_quantity})</h2>
                        <p class="transaction-date">${transaction.purchase_time}</p>
                        <p class="purchase-id">Purchase-ID: ${transaction.id}</p>
                        <p class="transaction-price">Price: ${transaction.total_price}</p>
                    </div>
                `;

                transactionsContainer.appendChild(transactionBlock);
            });

            // Update the page number text
            document.querySelector(
                ".transaction-pagination .page-text",
            ).textContent = `${data.current_page}/${data.total_pages}`;

            // Update pagination buttons visibility
            updatePaginationButtons(data.current_page, data.total_pages);
        })
        .catch((error) => console.error("Error loading transactions:", error));
}

function updatePaginationButtons(currentPage, totalPages) {
    const prevButton = document.querySelector(
        ".transaction-pagination .page-switcher.prev",
    );
    const nextButton = document.querySelector(
        ".transaction-pagination .page-switcher.next",
    );
}
