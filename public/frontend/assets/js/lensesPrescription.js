async function loadProductPrescription(lensesPrescriptionId) {
    try {
        const response = await fetch("../frontend/assets/js/products.json");
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

        const data = await response.json();
        const product = data.lensesData.find(p => p.id == lensesPrescriptionId);

        if (!product) {
            document.getElementById("lens-prescription-form").innerHTML =
                "<p>Error: Prescription form not found.</p>";
            return;
        }

        // Set initial price display
        document.getElementById("lens-product-price").textContent =
            `Price: PKR ${baseProductPrice}`;

        renderPrescriptionForm(product);
    } catch (error) {
        console.error("Error fetching product:", error);
        document.getElementById("lens-prescription-form").innerHTML =
            "<p>Error: Unable to load prescription form.</p>";
    }
}

function renderPrescriptionForm(product) {
    const formContainer = document.getElementById("lens-prescription-form");
    formContainer.innerHTML = "";

    // Set initial total price
    let currentTotal = baseProductPrice;
    updatePriceDisplay(currentTotal);

    product.fields.forEach((field) => {
        const fieldContainer = document.createElement("div");
        fieldContainer.className = "lenspres-section";

        const label = document.createElement("label");
        label.className = "lenspres-label";
        label.textContent = field.label;
        fieldContainer.appendChild(label);

        const dropdown = document.createElement("div");
        dropdown.className = "lenspres-custom-dropdown";

        const select = document.createElement("div");
        select.className = "lenspres-select";
        select.dataset.fieldName = field.name;

        // Set default value for quantity field
        if (field.name === "quantity") {
            select.textContent = "1 Pair";
            select.dataset.value = "1 Pair";
        } else {
            select.textContent = `Select your ${field.label.toLowerCase()}...`;
        }

        dropdown.appendChild(select);

        const optionsContainer = document.createElement("div");
        optionsContainer.className = "lenspres-options";

        const placeholderOption = document.createElement("div");
        placeholderOption.className = "lenspres-option lenspres-placeholder";
        placeholderOption.textContent = `Select your ${field.label.toLowerCase()}...`;
        optionsContainer.appendChild(placeholderOption);

        field.options.forEach((optionValue) => {
            const option = document.createElement("div");
            option.className = "lenspres-option";
            option.textContent = optionValue;
            option.dataset.value = optionValue;
            optionsContainer.appendChild(option);
        });

        dropdown.appendChild(optionsContainer);
        fieldContainer.appendChild(dropdown);
        formContainer.appendChild(fieldContainer);
    });

    // Add event listeners for dropdowns
    document.querySelectorAll(".lenspres-custom-dropdown").forEach((dropdown) => {
        const select = dropdown.querySelector(".lenspres-select");
        const options = dropdown.querySelector(".lenspres-options");
        const optionItems = dropdown.querySelectorAll(".lenspres-option");

        select.addEventListener("click", () => {
            dropdown.classList.toggle("open");
        });

        optionItems.forEach((option) => {
            option.addEventListener("click", () => {
                select.textContent = option.textContent;
                select.dataset.value = option.dataset.value;
                dropdown.classList.remove("open");

                // Update price when quantity changes
                if (select.dataset.fieldName === "quantity") {
                    const quantityMatch = option.dataset.value.match(/\d+/);
                    const quantity = quantityMatch ? parseInt(quantityMatch[0]) : 1;
                    currentTotal = baseProductPrice * quantity;
                    updatePriceDisplay(currentTotal);
                }
            });
        });

        document.addEventListener("click", (e) => {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove("open");
            }
        });
    });

    function updatePriceDisplay(price) {
        document.getElementById("lens-product-price").textContent =
            `Price: PKR ${price}`;
    }
}

async function addToCart() {
    try {
        const formContainer = document.getElementById("lens-prescription-form");
        if (!formContainer) {
            throw new Error("Prescription form container not found");
        }

        // Collect all form data
        const data = {
            product_id: currentProductId,
            base_price: baseProductPrice,
        };

        // Get all dropdown values
        document.querySelectorAll(".lenspres-select").forEach((select) => {
            const fieldName = select.dataset.fieldName;
            const value = select.dataset.value;
            if (fieldName && value) {
                data[fieldName] = value;
            }
        });

        // Get the calculated price
        const priceElement = document.getElementById("lens-product-price");
        if (priceElement && priceElement.textContent) {
            const priceText = priceElement.textContent.trim();
            const priceMatch = priceText.match(/PKR (\d+)/);
            if (priceMatch) {
                data.total_price = priceMatch[1];
            }
        }

        // Get CSRF token
        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        )?.content;
        if (!csrfToken) {
            throw new Error("Security token missing - please refresh the page");
        }

        // Make the API request
        const response = await fetch("/lenses-prescription", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: JSON.stringify(data),
        });

        // Handle response
        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || "Server returned an error");
        }

        if (!result.lenses_prescription_id) {
            throw new Error("Prescription ID missing in server response");
        }

        // Successful - redirect to checkout
        window.location.href = `/checkout?lenses_prescription_id=${result.lenses_prescription_id}`;
    } catch (error) {
        console.error("Checkout Error:", error);
        alert("Could not proceed to checkout: " + error.message);
        return false;
    }
}
