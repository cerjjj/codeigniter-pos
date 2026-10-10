(function () {
    "use strict";

    if (window.lucide) {
        window.lucide.createIcons();
    }

    const sidebar = document.getElementById("sidebar");
    const menuButton = document.getElementById("menuButton");
    const scrim = document.getElementById("scrim");
    const closeMenu = () => {
        sidebar?.classList.remove("open");
        scrim?.classList.remove("open");
        menuButton?.setAttribute("aria-expanded", "false");
    };

    menuButton?.addEventListener("click", () => {
        const open = sidebar?.classList.toggle("open");
        scrim?.classList.toggle("open", Boolean(open));
        menuButton.setAttribute("aria-expanded", String(Boolean(open)));
    });
    scrim?.addEventListener("click", closeMenu);

    document.querySelectorAll("form[data-confirm]").forEach((form) => {
        form.addEventListener("submit", (event) => {
            if (!window.confirm(form.dataset.confirm)) event.preventDefault();
        });
    });

    document.querySelectorAll("input[type=file][data-preview]").forEach((input) => {
        input.addEventListener("change", () => {
            const file = input.files?.[0];
            const preview = document.getElementById(input.dataset.preview);
            if (!file || !preview) return;
            const image = document.createElement("img");
            image.src = URL.createObjectURL(file);
            image.alt = "Selected image preview";
            preview.replaceChildren(image);
        });
    });

    const productSelect = document.querySelector("[data-product-select]");
    const quantityInput = document.querySelector("[data-quantity]");
    if (productSelect && quantityInput) {
        const formatMoney = (amount) => new Intl.NumberFormat("en-PH", { style: "currency", currency: "PHP" }).format(amount);
        const updateSale = () => {
            const option = productSelect.selectedOptions[0];
            const price = Number(option?.dataset.price || 0);
            const stock = Number(option?.dataset.stock || 0);
            const quantity = Math.max(1, Number(quantityInput.value || 1));
            document.querySelector("[data-unit-price]").textContent = formatMoney(price);
            document.querySelector("[data-summary-quantity]").textContent = String(quantity);
            document.querySelector("[data-sale-total]").textContent = formatMoney(price * quantity);
            document.querySelector("[data-stock-message]").textContent = option?.value ? `${stock} units available.` : "Select a product to see its available stock.";
            quantityInput.max = option?.value ? String(stock) : "";
        };
        productSelect.addEventListener("change", updateSale);
        quantityInput.addEventListener("input", updateSale);
        updateSale();
    }
})();
