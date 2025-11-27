// Existing formData structure
const formData = {
    lensType: "",
    lensFeature: "",
    lensOption: "",
    lensPrice: 0,
    totalPrice: 0,
    prescription: {
        od: { sph: null, cyl: null, axis: null, add: null },
        os: { sph: null, cyl: null, axis: null, add: null },
        pd: null,
        pdDual: { right: null, left: null },
        readingMagnification: null,
    },
    image: null,
    prescriptionType: "manual",
};

const lensTypeLabels = {
    distance: "Single Vision Distance",
    reading: "Reading",
    bifocal: "Bifocal",
    progressive: "Progressive",
    "non-prescription": "Non-Prescription",
};

const featureLabels = {
    clear: "Clear",
    "blue-light": "Blue Light Filtering",
    transition: "Transition & Photochromic",
    tinted: "Tinted",
};

const featureDescriptions = {
    clear: "A clear lens provides precise vision correction without any tint or color distortion, offering natural, unobstructed sight.",
    "blue-light":
        "A blue light filtering lens reduces digital eye strain by blocking harmful blue light, providing comfort and protection for extended screen time.",
    transition:
        "Transitions (photochromic) lenses adjust from clear to dark based on sunlight exposure, offering seamless indoor-to-outdoor vision protection.",
    tinted: "A tinted lens reduces glare and enhances visual comfort in bright conditions, adding both style and sun protection.",
};

let currentStep = 1;
let totalSteps = 5;

const magnificationOptions = [
    0.25, 0.5, 0.75, 1.0, 1.25, 1.5, 1.75, 2.0, 2.25, 2.5, 2.75, 3.0, 3.25, 3.5,
    3.75, 4.0, 4.25, 4.5, 4.75, 5.0, 5.25, 5.5, 5.75, 6.0,
];

const lensOptions = {
    distance: {
        clear: [
            {
                name: "Anti-Reflective",
                description:
                    "Anti-reflection clear single vision lens – crisp, glare-free vision for ultimate comfort and clarity.",
                price: 1000,
            },
            {
                name: "Scratch Resistance Anti-Reflective",
                description:
                    "Scratch-resistant anti-reflective lenses combine durability with reduced glare for enhanced clarity and comfort.",
                price: 2600,
            },
            {
                name: "Privo",
                description:
                    "Privo lenses offer advanced comfort and clarity, designed for all-day wear with enhanced visual precision and durability.",
                price: 3500,
            },
            {
                name: "Super Thin 1.67 Index",
                description:
                    "Super Thin 1.67 index lenses offer a lightweight and slim profile while providing excellent optical clarity.",
                price: 4500,
            },
            {
                name: "Ultra Thin 1.74 Index",
                description:
                    "Ultra Thin 1.74 index lenses are extremely lightweight and thin, offering superior optical performance for strong prescriptions.",
                price: 16000,
            },
        ],
        "blue-light": [
            {
                name: "Basic Blue Light Filtering",
                description:
                    "Basic blue light filtering lens to reduce eye strain from digital screens.",
                price: 1400,
            },
            {
                name: "DSC Digital Plus",
                description:
                    "DSC Digital Plus lenses provide high-definition clarity with advanced digital surfacing for precision and sharper vision.",
                price: 3500,
            },
            {
                name: "Privo Edge Armor BRF",
                description:
                    "Privo Edge Armor BRF lenses offer scratch resistance and blue light filtering for durable, comfortable wear.",
                price: 6000,
            },
        ],
        transition: [
            {
                name: "Photochromic",
                description:
                    "Photochromic lenses automatically adjust from clear to tinted in response to sunlight, offering comfort and UV protection in varying light conditions.",
                price: 1700,
            },
            {
                name: "Transition ",
                description:
                    "Transitions lenses automatically adjust from clear to tinted in response to light changes, providing comfort and protection from UV rays.",
                price: 3500,
            },
            {
                name: "Light Intelligent Transition",
                description:
                    "Light Intelligent Transitions lenses adapt seamlessly to changing light conditions, providing optimal vision and comfort indoors and outdoors.",
                price: 4800,
            },
            {
                name: "Privo Transmatic ",
                description:
                    "Privo Transmatic lenses automatically adjust to light changes, providing optimal vision and comfort in various lighting conditions.",
                price: 13000,
            },
        ],
        tinted: [
            {
                name: "Single Shaded 80 Percent",
                description:
                    "80% single-shaded tinted lens – bold sun protection with a uniform, stylish tint.",
                price: 2500,
            },
            {
                name: "Gradient 80 Percent",
                description:
                    "80% gradient tinted lens – stylish sun protection with a smooth, comfortable fade.",
                price: 2500,
            },
            {
                name: "Polarized ",
                description:
                    "Polarized lenses reduce glare from reflective surfaces, enhancing clarity and comfort for outdoor activities in bright sunlight.",
                price: 12000,
            },
        ],
    },
    reading: {
        clear: [
            {
                name: "Anti-Reflective ",
                description:
                    "Anti-reflection clear single vision lens – crisp, glare-free vision for ultimate comfort and clarity.",
                price: 1000,
            },
            {
                name: "Scratch Resistance Anti-Reflective ",
                description:
                    "Scratch-resistant anti-reflective lenses combine durability with reduced glare for enhanced clarity and comfort.",
                price: 2600,
            },
            {
                name: "Privo",
                description:
                    "Privo lenses offer advanced comfort and clarity, designed for all-day wear with enhanced visual precision and durability.",
                price: 3500,
            },
        ],
        "blue-light": [
            {
                name: "Basic Blue Light Filtering",
                description:
                    "Basic blue light filtering lens to reduce eye strain from digital screens.",
                price: 1400,
            },
            {
                name: "DSC Digital Plus",
                description:
                    "DSC Digital Plus lenses provide high-definition clarity with advanced digital surfacing for precision and sharper vision.",
                price: 3500,
            },
            {
                name: "Privo Edge Armor BRF",
                description:
                    "Privo Edge Armor BRF lenses offer scratch resistance and blue light filtering for durable, comfortable wear.",
                price: 6000,
            },
        ],
    },
    bifocal: {
        clear: [
            {
                name: "Scratch Resistance without Anti-Reflection",
                description:
                    "Scratch-resistant lenses provide durable protection against scratches without an anti-reflective coating.",
                price: 2600,
            },
            {
                name: "Anti-Reflection",
                description:
                    "Anti-reflection clear bifocal lens – dual-vision clarity with reduced glare for comfortable, sharp sight.",
                price: 5500,
            },
        ],
        "blue-light": [
            {
                name: "Blue Light Filtering",
                description:
                    "A blue light filtering lens reduces digital eye strain by blocking harmful blue light, providing comfort and protection for extended screen time.",
                price: 8600,
            },
        ],
        transition: [
            {
                name: "Photochromic",
                description:
                    "Photochromic lenses automatically adjust from clear to tinted in response to sunlight, offering comfort and UV protection in varying light conditions.",
                price: 5800,
            },
            {
                name: "Advance Photochromic",
                description:
                    "Advanced photochromic bifocal lens – dual-vision clarity with light-adjusting comfort for any environment.",
                price: 9500,
            },
        ],
    },
    progressive: {
        clear: [
            {
                name: "Anti-Reflective",
                description:
                    "Advanced photochromic bifocal lens – dual-vision clarity with light-adjusting comfort for any environment.",
                price: 4500,
            },
            {
                name: "ABC Anti Reflective",
                description:
                    "ABC anti-reflective clear progressive lens – sharp, comfortable vision across all distances with reduced glare for a clear view.",
                price: 6200,
            },
            {
                name: "Signo Hd Anti-Reflective",
                description:
                    "Signo HD Anti-Reflective lenses provide high-definition clarity with glare reduction for improved visual comfort.",
                price: 12000,
            },
            {
                name: "Privo Active Anti-Reflective",
                description:
                    "Privo Active Anti-Reflective lenses combine glare reduction with enhanced clarity, perfect for active lifestyles and outdoor performance.",
                price: 16000,
            },
        ],
        "blue-light": [
            {
                name: "ABC Exceed Blue",
                description:
                    "ABC Exceed Blue progressive lens – advanced blue light filtering for eye comfort and clear vision at all distances.",
                price: 7500,
            },
            {
                name: "Signo Hd",
                description:
                    "Signo HD lenses deliver high-definition clarity and precision for enhanced visual performance.",
                price: 13500,
            },
            {
                name: "Privo Active",
                description:
                    "Privo Active lenses are designed for dynamic lifestyles, providing sharp vision, durability, and UV protection, ideal for outdoor and sports activities.",
                price: 19000,
            },
        ],
        transition: [
            {
                name: "ABC Photo Lens",
                description:
                    "ABC Photo progressive lens – seamless light-adaptive transitions for clear, comfortable vision indoors and outdoors.",
                price: 9800,
            },
            {
                name: "Signo Transition",
                description:
                    "Signo Transitions lenses automatically darken in sunlight, providing UV protection and convenience.",
                price: 16000,
            },
        ],
    },
    "non-prescription": {
        clear: [
            {
                name: "Clear",
                description:
                    "A clear lens provides precise vision correction without any tint or color distortion, offering natural, unobstructed sight.",
                price: 1000,
            },
        ],
        "blue-light": [
            {
                name: "Blue Light Filtering",
                description:
                    "A blue light filtering lens reduces digital eye strain by blocking harmful blue light, providing comfort and protection for extended screen time.",
                price: 1500,
            },
        ],
    },
};

const audioMessages = {
    step1: "Please select your lens type.",
    step2: "Enter your prescription details or upload an image.",
    step2NonPrescription: "Choose your lens feature.",
    step3: "Select your lens features.",
    step4: "Pick your lens options.",
    step5: "Review your order before submitting.",
};

// Toggle ADD fields based on lens type
// function toggleAddFields() {
//     const isBifocalOrProgressive = ["bifocal", "progressive"].includes(
//         formData.lensType
//     );
//     document.querySelectorAll(".add-field").forEach((field) => {
//         field.classList.toggle("hidden", !isBifocalOrProgressive);
//     });
// }
function toggleAddFields() {
    document.querySelectorAll('.add-field').forEach(field => {
        field.classList.remove('hidden');
    });
}

// Toggle dual PD fields
function toggleDualPd() {
    const isChecked = document.getElementById("dualPd").checked;
    document
        .getElementById("dualPdFields")
        .classList.toggle("active", isChecked);
    if (!isChecked) {
        formData.prescription.pdDual.right = null;
        formData.prescription.pdDual.left = null;
        document.getElementById("pdRight").value = "";
        document.getElementById("pdLeft").value = "";
    }
}

// Initialize combobox functionality
function initializeComboboxes() {
    document.querySelectorAll(".combobox").forEach((combobox) => {
        const input = combobox.querySelector("input");
        const dropdown = combobox.querySelector(".combobox-dropdown");
        const options = dropdown.querySelectorAll("li");

        // Show dropdown on input click or focus
        input.addEventListener("click", () => {
            closeAllDropdowns();
            dropdown.classList.add("active");
        });
        input.addEventListener("focus", () => {
            closeAllDropdowns();
            dropdown.classList.add("active");
        });

        // Handle option selection
        options.forEach((option) => {
            option.addEventListener("click", () => {
                input.value = option.getAttribute("data-value");
                input.dispatchEvent(new Event("input")); // Trigger input event
                dropdown.classList.remove("active");
            });
        });

        // Close dropdown on click outside
        document.addEventListener("click", (e) => {
            if (!combobox.contains(e.target)) {
                dropdown.classList.remove("active");
            }
        });
    });
}

// Close all dropdowns
function closeAllDropdowns() {
    document.querySelectorAll(".combobox-dropdown").forEach((dropdown) => {
        dropdown.classList.remove("active");
    });
}

// Modified DOMContentLoaded to handle custom combobox
document.addEventListener("DOMContentLoaded", function () {
    displayEyeframeDetails();
    initializeMagnificationGrid();
    toggleAddFields();
    initializeComboboxes();

    // Update formData on input change
    document
        .querySelectorAll(
            'input[name^="od_"], input[name^="os_"], input[id="pd"], input[id="pdRight"], input[id="pdLeft"]'
        )
        .forEach((input) => {
            input.addEventListener("input", function () {
                const field =
                    this.name.split("_")[1] ||
                    this.id.replace("pd", "").toLowerCase();
                const eye = this.name.startsWith("od_")
                    ? "od"
                    : this.name.startsWith("os_")
                        ? "os"
                        : null;
                if (eye) {
                    formData.prescription[eye][field] = this.value
                        ? parseFloat(this.value)
                        : null;
                } else if (this.id === "pd") {
                    formData.prescription.pd = this.value
                        ? parseFloat(this.value)
                        : null;
                } else if (this.id === "pdRight") {
                    formData.prescription.pdDual.right = this.value
                        ? parseFloat(this.value)
                        : null;
                } else if (this.id === "pdLeft") {
                    formData.prescription.pdDual.left = this.value
                        ? parseFloat(this.value)
                        : null;
                }
            });
        });

    // Existing event listeners unchanged
    // document
    //     .getElementById("imageUpload")
    //     .addEventListener("change", function (e) {
    //         const file = e.target.files[0];
    //         if (file) {
    //             if (file.size > 5 * 1024 * 1024) {
    //                 showUploadError("File size exceeds 5MB limit");
    //                 return;
    //             }
    //             const reader = new FileReader();
    //             reader.onload = function (event) {
    //                 const preview = document.getElementById("imagePreview");
    //                 preview.src = event.target.result;
    //                 preview.style.display = "block";
    //                 formData.image = event.target.result;
    //                 document.getElementById("uploadError").style.display =
    //                     "none";
    //                 document.getElementById("uploadSuccess").style.display =
    //                     "block";
    //             };
    //             reader.readAsDataURL(file);
    //         }
    //     });
    document.getElementById('imageUpload').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (!file) {
            showUploadError('No file selected. Please upload an image.');
            this.value = '';
            return;
        }

        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedTypes.includes(file.type) && !allowedExtensions.includes(fileExtension)) {
            showUploadError('Invalid file format. Only JPG, JPEG, or PNG images are allowed.');
            this.value = ''; // Reset input
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            showUploadError('File size exceeds 5MB limit');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            const preview = document.getElementById('imagePreview');
            preview.src = event.target.result;
            preview.style.display = 'block';
            formData.image = event.target.result;
            document.getElementById('uploadError').style.display = 'none';
            document.getElementById('uploadSuccess').style.display = 'block';

        };
        reader.readAsDataURL(file);

    });

    // document
    //     .getElementById("uploadArea")
    //     .addEventListener("click", function () {
    //         document.getElementById("imageUpload").click();
    //     });
    document.getElementById('uploadArea').addEventListener('click', function () {
        const fileInput = document.getElementById('imageUpload');
        fileInput.value = ''; 
        fileInput.click();
    });

    document.querySelectorAll(".cardT[data-lensType]").forEach((cardT) => {
        cardT.addEventListener("click", toggleAddFields);
    });

    const urlParams = new URLSearchParams(window.location.search);
    const preSelectedLensType = urlParams.get("lensType");
    if (preSelectedLensType) {
        let mappedLensType = preSelectedLensType;
        if (preSelectedLensType === "multifocal") {
            mappedLensType = "progressive";
        }
        const lenscardT = document.querySelector(
            `.cardT[data-lensType="${mappedLensType}"]`
        );
        if (lenscardT) {
            formData.lensType = mappedLensType;
            selectcardT(lenscardT, "lensType");
        }
    }

    updateProgressBar();
    playAudio("step1");
});

// Modified generatePdRow to handle Right/Left
function generatePdRow() {
    const isDualPdChecked = document.getElementById("dualPd").checked;
    const hasDualPdValues =
        formData.prescription.pdDual.right !== null ||
        formData.prescription.pdDual.left !== null;
    if (isDualPdChecked && hasDualPdValues) {
        return `
  <tr>
    <td>Pupillary Distance</td>
    <td colspan="4">
      Right: ${formatValue(formData.prescription.pdDual.right)} mm /
      Left: ${formatValue(formData.prescription.pdDual.left)} mm
    </td>
  </tr>
`;
    }
    return `<tr><td>Pupillary Distance</td><td colspan="4">${formatValue(
        formData.prescription.pd
    )} mm</td></tr>`;
}

// Modified submitOrder function to fix the JSON parsing error
async function submitOrder() {
    try {
        const frameData = await loadFrameData();
        const formattedOrderData = {
            lensType: lensTypeLabels[formData.lensType] || null,
            lensFeature: featureLabels[formData.lensFeature] || null,
            lensOption: formData.lensOption || null,
            lensPrice: formData.lensPrice || 0,
            totalPrice: formData.totalPrice || 0,
            prescriptionType: formData.prescriptionType,
            prescription: formData.prescription,
            imageUploaded: !!formData.image,
            image: formData.image,
            frame: {
                id: String(frameData.id),
                name: frameData.name,
                price: frameData.price,
                imageUrl: frameData.imageUrl,
            },
        };

        console.log("Sending data:", JSON.stringify(formattedOrderData));

        // Get the CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Send prescription data to backend
        const response = await fetch("/prescriptions/store", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify(formattedOrderData),
        });

        // Check if response is OK before trying to parse JSON
        if (!response.ok) {
            const errorText = await response.text();
            console.error("Server error response:", errorText);
            throw new Error(`Server error: ${response.status} ${response.statusText}`);
        }

        const result = await response.json();
        console.log("Success response:", result);

        // DIRECT REDIRECT TO CHECKOUT - no popup or delay
        window.location.href = `/checkout?prescription_id=${result.prescription_id}`;
    } catch (error) {
        console.error("Error saving prescription:", error);
        alert("There was an error saving your prescription. Please try again.");
    }
}

// Existing functions unchanged
async function loadFrameData() {
    // Get product data from the controller endpoint
    try {
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get("productId");

        if (!productId) {
            throw new Error("Product ID not provided");
        }

        const response = await fetch(`/products/${productId}`);
        if (!response.ok) throw new Error("Failed to fetch product data");

        const productData = await response.json();

        return {
            id: productData.id,
            name: productData.name,
            price: productData.price,
            imageUrl: productData.main_image
                ? `/uploads/products/${productData.main_image}`
                : "https://via.placeholder.com/300",
        };
    } catch (error) {
        console.error("Error loading product data:", error);
        return {};
    }
}

async function displayEyeframeDetails() {
    const frameData = await loadFrameData();
    document.getElementById("eyeframeImage").src =
        frameData.imageUrl || "https://via.placeholder.com/300";
    document.getElementById("eyeframeName").textContent =
        frameData.name || "Unknown Frame";
    document.getElementById("eyeframePrice").textContent = `Rs ${frameData.price?.toLocaleString() || 0
        }`;

    // Store the frame ID in the hidden element
    if (document.getElementById("eyeframeId")) {
        document.getElementById("eyeframeId").textContent = frameData.id;
    }

    console.log("Frame data displayed:", frameData);
}

function initializeMagnificationGrid() {
    const container = document.getElementById("magnificationGrid");
    container.innerHTML = "";
    magnificationOptions.forEach((value) => {
        const div = document.createElement("div");
        div.className = "magnification-option";
        div.textContent = `+${value.toFixed(2)}`;
        div.onclick = () => {
            formData.prescription.readingMagnification = value;
            document
                .querySelectorAll(".magnification-option")
                .forEach((opt) => opt.classList.remove("selected"));
            div.classList.add("selected");
            document.getElementById("magnificationError").style.display =
                "none";
        };
        container.appendChild(div);
    });
}

function playAudio(stepId) {
    const message =
        stepId === "step2" && formData.lensType === "non-prescription"
            ? audioMessages.step2NonPrescription
            : audioMessages[stepId];
    if (window.speechSynthesis) {
        const utterance = new SpeechSynthesisUtterance(message);
        utterance.lang = "en-US";
        utterance.volume = 1;
        utterance.rate = 1;
        utterance.pitch = 1;
        window.speechSynthesis.cancel();
        window.speechSynthesis.speak(utterance);
    } else {
        console.warn("Text-to-speech not supported in this browser.");
    }
}

function nextStep() {
    if (!validateStep(currentStep)) return;
    document.getElementById(`step${currentStep}`).classList.remove("active");
    currentStep++;
    window.scrollTo({ top: 0, behavior: "smooth" });
    if (formData.lensType === "non-prescription") {
        if (currentStep === 2) {
            initializeNonPrescriptionFeatures();
            playAudio("step2");
        }
        if (currentStep === 3) {
            currentStep = 5;
            updateSummary();
            playAudio("step5");
        }
    } else {
        if (currentStep === 2) {
            playAudio("step2");
        }
        if (currentStep === 3) {
            initializeLensFeatures();
            playAudio("step3");
        }
        if (currentStep === 4) {
            initializeLensOptions();
            playAudio("step4");
        }
        if (currentStep === 5) {
            updateSummary();
            playAudio("step5");
        }
    }
    document.getElementById(`step${currentStep}`).classList.add("active");
    updateProgressBar();
}

function prevStep() {
    document.getElementById(`step${currentStep}`).classList.remove("active");
    currentStep--;
    if (formData.lensType === "non-prescription" && currentStep === 3) {
        currentStep = 2;
        initializeNonPrescriptionFeatures();
        playAudio("step2");
    } else {
        if (currentStep === 2) {
            playAudio("step2");
        }
        if (currentStep === 3) {
            initializeLensFeatures();
            playAudio("step3");
        }
        if (currentStep === 4) {
            initializeLensOptions();
            playAudio("step4");
        }
        if (currentStep === 1) {
            playAudio("step1");
        }
    }
    document.getElementById(`step${currentStep}`).classList.add("active");
    updateProgressBar();
}

function updateProgressBar() {
    const steps = formData.lensType === "non-prescription" ? 3 : 5;
    const adjustedStep =
        formData.lensType === "non-prescription" && currentStep === 5
            ? 3
            : currentStep;
    const progressPercentage = ((adjustedStep - 1) / (steps - 1)) * 100;
    document.getElementById(
        "progress-fill"
    ).style.width = `${progressPercentage}%`;

    document.querySelectorAll(".progress-step").forEach((el, i) => {
        const step = i + 1;
        const stepNumber = el.querySelector(".step-number");
        const stepLabel = el.querySelector(".step-label");

        if (formData.lensType === "non-prescription") {
            if (step > 3) {
                el.classList.add("hidden");
            } else {
                el.classList.remove("hidden");
                if (step === 3) {
                    stepNumber.textContent = "3";
                    stepLabel.textContent = "Review";
                }
            }
        } else {
            el.classList.remove("hidden");
            if (step === 5) {
                stepNumber.textContent = "5";
                stepLabel.textContent = "Review";
            } else if (step === 4) {
                stepNumber.textContent = "4";
                stepLabel.textContent = "Lens Options";
            }
        }

        stepNumber.classList.toggle("completed", step <= adjustedStep);
        stepNumber.classList.toggle("active", step === adjustedStep);
        stepLabel.classList.toggle("active", step === adjustedStep);
    });

    const progressContainer = document.getElementById("progress-container");
    const visibleSteps = Array.from(
        progressContainer.querySelectorAll(".progress-step")
    ).filter((step) => !step.classList.contains("hidden"));
    const progressBar = progressContainer.querySelector(".progress-bar");

    if (formData.lensType === "non-prescription") {
        const stepWidthPercentage = 100 / (visibleSteps.length - 1);
        progressBar.style.width = `${stepWidthPercentage * (visibleSteps.length - 1)
            }%`;
    } else {
        progressBar.style.width = "100%";
    }
}

function validateStep(step) {
    if (formData.lensType === "non-prescription") {
        switch (step) {
            case 1:
                if (!formData.lensType) {
                    alert("Please select a lens type");
                    return false;
                }
                return true;
            case 2:
                if (!formData.lensFeature) {
                    alert("Please select a lens feature");
                    return false;
                }
                return true;
            default:
                return true;
        }
    } else if (formData.lensType === "reading") {
        switch (step) {
            case 1:
                if (!formData.lensType) {
                    alert("Please select a lens type");
                    return false;
                }
                return true;
            // case 2:
            //     if (formData.prescriptionType === "upload") {
            //         if (!formData.image) {
            //             showUploadError("Please upload a prescription image");
            //             return false;
            //         }
            //     } 
            //     else {
            //         if (!formData.prescription.readingMagnification) {
            //             document.getElementById(
            //                 "magnificationError"
            //             ).style.display = "block";
            //             return false;
            //         }
            //     }
            //     document.getElementById("magnificationError").style.display =
            //         "none";
            //     document.getElementById("uploadError").style.display = "none";
            //     return true;
            case 2:
                if (formData.prescriptionType === 'upload') {
                    if (!formData.image) {
                        showUploadError('Please upload a prescription image');
                        return false;
                    }
                    document.getElementById('prescriptionError').style.display = 'none';
                    document.getElementById('uploadError').style.display = 'none';
                    return true;
                } else {
                    const hasData = Object.values(formData.prescription.od).some(v => v !== null) &&
                        Object.values(formData.prescription.os).some(v => v !== null);
                    const isValid = document.querySelectorAll('input:invalid').length === 0;
                    const odCyl = formData.prescription.od.cyl;
                    const odAxis = formData.prescription.od.axis;
                    const osCyl = formData.prescription.os.cyl;
                    const osAxis = formData.prescription.os.axis;

                    if ((odCyl !== null && odCyl !== '' && (odAxis === null || odAxis === '')) ||
                        (osCyl !== null && osCyl !== '' && (osAxis === null || osAxis === ''))) {
                        document.getElementById('prescriptionError').textContent = 'If you enter CYL, AXIS is required for both eyes.';
                        document.getElementById('prescriptionError').style.display = 'block';
                        return false;
                    }
                    document.getElementById('prescriptionError').textContent = 'Please fill in all required fields correctly.';
                    if (!hasData || !isValid) {
                        document.getElementById('prescriptionError').style.display = 'block';
                        return false;
                    }
                    document.getElementById('prescriptionError').style.display = 'none';
                    document.getElementById('uploadError').style.display = 'none';
                    return true;
                }
            case 3:
                if (!formData.lensFeature) {
                    alert("Please select a lens feature");
                    return false;
                }
                return true;
            case 4:
                if (!formData.lensOption) {
                    alert("Please select a lens option");
                    return false;
                }
                return true;
            default:
                return true;
        }
    } else {
        switch (step) {
            case 1:
                if (!formData.lensType) {
                    alert("Please select a lens type");
                    return false;
                }
                return true;
            // case 2:
            //     if (formData.prescriptionType === "upload") {
            //         if (!formData.image) {
            //             showUploadError("Please upload a prescription image");
            //             return false;
            //         }
            //     } else {
            //         const hasData =
            //             Object.values(formData.prescription.od).some(
            //                 (v) => v !== null
            //             ) &&
            //             Object.values(formData.prescription.os).some(
            //                 (v) => v !== null
            //             ) &&
            //             formData.prescription.pd !== null;
            //         const isValid =
            //             document.querySelectorAll("input:invalid").length === 0;
            //         if (!hasData || !isValid) {
            //             document.getElementById(
            //                 "prescriptionError"
            //             ).style.display = "block";
            //             return false;
            //         }
            //     }
            //     document.getElementById("prescriptionError").style.display =
            //         "none";
            //     document.getElementById("uploadError").style.display = "none";
            //     return true;
             case 2:
                if (formData.prescriptionType === 'upload') {
                    if (!formData.image) {
                        showUploadError('Please upload a prescription image');
                        return false;
                    }
                } else {
                    const hasData = Object.values(formData.prescription.od).some(v => v !== null) &&
                        Object.values(formData.prescription.os).some(v => v !== null);
                    // comment logic for required pd now its optional also remove required from html written in pd input field   &&
                    // formData.prescription.pd !== null;
                    const isValid = document.querySelectorAll('input:invalid').length === 0;
                    // add logic if cyl value is not null then axis value should be present
                    const odCyl = formData.prescription.od.cyl;
                    const odAxis = formData.prescription.od.axis;
                    const osCyl = formData.prescription.os.cyl;
                    const osAxis = formData.prescription.os.axis;

                    // If CYL is entered, AXIS is required for both eyes
                    if ((odCyl !== null && odCyl !== '' && (odAxis === null || odAxis === '')) ||
                        (osCyl !== null && osCyl !== '' && (osAxis === null || osAxis === ''))) {
                        document.getElementById('prescriptionError').textContent = 'If you enter CYL, AXIS is required for both eyes.';
                        document.getElementById('prescriptionError').style.display = 'block';
                        return false;
                    }
                    document.getElementById('prescriptionError').textContent = 'Please fill in all required fields correctly.';
                    if (!hasData || !isValid) {
                        document.getElementById('prescriptionError').style.display = 'block';
                        return false;
                    }
                }
                document.getElementById('prescriptionError').style.display = 'none';
                document.getElementById('uploadError').style.display = 'none';
                return true;
            case 3:
                if (!formData.lensFeature) {
                    alert("Please select a lens feature");
                    return false;
                }
                return true;
            case 4:
                if (!formData.lensOption) {
                    alert("Please select a lens option");
                    return false;
                }
                return true;
            default:
                return true;
        }
    }
}

function selectcardT(cardT, type) {
    const selector = `[data-${type}]`;
    document
        .querySelectorAll(selector)
        .forEach((c) => c.classList.remove("selected"));
    cardT.classList.add("selected");
    formData[type] = cardT.getAttribute(`data-${type}`);
    if (type === "lensType") {
        updateStep2();
    }
    nextStep();
}

// function updateStep2() {
//     const isNonPrescription = formData.lensType === "non-prescription";
//     document
//         .getElementById("prescription-type")
//         .classList.toggle("hidden", isNonPrescription);
//     document
//         .getElementById("manualPrescription")
//         .classList.toggle(
//             "active",
//             !isNonPrescription &&
//             formData.lensType !== "reading" &&
//             formData.prescriptionType === "manual"
//         );
//     document
//         .getElementById("readingMagnification")
//         .classList.toggle(
//             "active",
//             formData.lensType === "reading" &&
//             formData.prescriptionType === "manual"
//         );
//     document
//         .getElementById("uploadPrescription")
//         .classList.toggle(
//             "active",
//             !isNonPrescription && formData.prescriptionType === "upload"
//         );
//     document
//         .getElementById("nonPrescriptionFeatures")
//         .classList.toggle("active", isNonPrescription);
//     document.getElementById("step2-title").textContent = isNonPrescription
//         ? "Select Lens Feature"
//         : "Enter Your Prescription";
//     document.getElementById("step-2-label").textContent = isNonPrescription
//         ? "Lens Feature"
//         : "Prescription";
//     document.getElementById("step-3-label").textContent = isNonPrescription
//         ? "Review"
//         : "Lens Features";
//     totalSteps = isNonPrescription ? 3 : 5;
//     updateProgressBar();
// }
function updateStep2() {
    const isNonPrescription = formData.lensType === 'non-prescription';
    document.getElementById('prescription-type').classList.toggle('hidden', isNonPrescription);
    // Show manualPrescription for all except non-prescription
    document.getElementById('manualPrescription').classList.toggle('active', !isNonPrescription && formData.prescriptionType === 'manual');
    // Hide magnification grid always
    document.getElementById('readingMagnification').classList.remove('active');
    document.getElementById('uploadPrescription').classList.toggle('active', !isNonPrescription && formData.prescriptionType === 'upload');
    document.getElementById('nonPrescriptionFeatures').classList.toggle('active', isNonPrescription);
    document.getElementById('step2-title').textContent = isNonPrescription ? 'Select Lens Feature' : 'Enter Your Prescription';
    document.getElementById('step-2-label').textContent = isNonPrescription ? 'Lens Feature' : 'Prescription';
    document.getElementById('step-3-label').textContent = isNonPrescription ? 'Review' : 'Lens Features';
    totalSteps = isNonPrescription ? 3 : 5;
    updateProgressBar();
}

function initializeNonPrescriptionFeatures() {
    const container = document.getElementById(
        "nonPrescriptionFeatureContainer"
    );
    container.innerHTML = "";
    const features = lensOptions["non-prescription"]
        ? Object.keys(lensOptions["non-prescription"])
        : [];
    features.forEach((feature) => {
        const options = lensOptions["non-prescription"][feature];
        options.forEach((opt) => {
            const div = document.createElement("div");
            div.className = "cardT";
            div.setAttribute("data-lensFeature", feature);
            div.innerHTML = `
    <img class="cardT-image" src="../frontend/assets/images/${opt.name
                    .replace(/\s+/g, "-")
                    .toLowerCase()}.jpg" alt="${opt.name} Lens Option Icon">
    <div class="details"><div class="cardT-title">${opt.name}<span>Rs:${opt.price
                }</span></div>
    <div class="cardT-desc">${opt.description}</div></div>
  `;
            div.onclick = () => {
                formData.lensFeature = feature;
                formData.lensOption = opt.name;
                formData.lensPrice = opt.price;
                document
                    .querySelectorAll("#nonPrescriptionFeatureContainer .cardT")
                    .forEach((c) => c.classList.remove("selected"));
                div.classList.add("selected");
                updateTotalPrice();
                nextStep();
            };
            container.appendChild(div);
        });
    });
    formData.lensFeature = "";
    formData.lensOption = "";
    formData.lensPrice = 0;
    updateTotalPrice();
}

function initializeLensFeatures() {
    const container = document.getElementById("lensFeatureContainer");
    container.innerHTML = "";
    const features = lensOptions[formData.lensType]
        ? Object.keys(lensOptions[formData.lensType])
        : [];
    features.forEach((feature) => {
        const div = document.createElement("div");
        div.className = "cardT";
        div.setAttribute("data-lensFeature", feature);
        div.innerHTML = `
  <img class="cardT-image" src="../frontend/assets/images/${feature}.jpg" alt="${featureLabels[feature]} Lens Icon">
  <div class="details"><div class="cardT-title">${featureLabels[feature]}</div>
  <div class="cardT-desc">${featureDescriptions[feature]}</div></div>
`;
        div.onclick = () => {
            formData.lensFeature = feature;
            document
                .querySelectorAll("#lensFeatureContainer .cardT")
                .forEach((c) => c.classList.remove("selected"));
            div.classList.add("selected");
            nextStep();
        };
        container.appendChild(div);
    });
    formData.lensFeature = "";
    formData.lensOption = "";
    formData.lensPrice = 0;
    updateTotalPrice();
}

function initializeLensOptions() {
    document
        .querySelectorAll(".step4-variant")
        .forEach((variant) => variant.classList.add("hidden"));
    const variant = document.getElementById(`step4-${formData.lensType}`);
    if (variant) {
        variant.classList.remove("hidden");
        const container = document.getElementById(
            `${formData.lensType}-tier-options`
        );
        container.innerHTML = "";
        const options =
            lensOptions[formData.lensType]?.[formData.lensFeature] || [];
        options.forEach((opt) => {
            const div = document.createElement("div");
            div.className = "cardT";
            div.innerHTML = `
    <img class="cardT-image" src="../frontend/assets/images/${opt.name
                    .replace(/\s+/g, "-")
                    .toLowerCase()}.jpg" alt="${opt.name} Lens Option Icon">
    <div class="details"><div class="cardT-title">${opt.name} <span>Rs:${opt.price
                }</span></div>
    <div class="cardT-desc">${opt.description}</div></div>
  `;
            div.onclick = () => {
                formData.lensOption = opt.name;
                formData.lensPrice = opt.price;
                document
                    .querySelectorAll(
                        `#${formData.lensType}-tier-options .cardT`
                    )
                    .forEach((c) => c.classList.remove("selected"));
                div.classList.add("selected");
                updateTotalPrice();
                nextStep();
            };
            container.appendChild(div);
        });
        formData.lensOption = "";
        formData.lensPrice = 0;
        updateTotalPrice();
    }
}

async function updateTotalPrice() {
    try {
        const frameData = await loadFrameData();
        const framePrice = parseFloat(frameData.price) || 0;
        const lensPrice = parseFloat(formData.lensPrice) || 0;

        formData.totalPrice = framePrice + lensPrice;

        if (currentStep === 5) {
            updateSummary();
        }
    } catch (error) {
        console.error("Error calculating total price:", error);
        formData.totalPrice = 0;
    }
}

function selectPrescriptionType(type) {
    formData.prescriptionType = type;
    document
        .querySelectorAll(".prescription-type-btn")
        .forEach((btn) => btn.classList.remove("selected"));
    document
        .querySelector(
            `.prescription-type-btn[onclick="selectPrescriptionType('${type}')"]`
        )
        .classList.add("selected");
    document
        .querySelectorAll(".prescription-section")
        .forEach((section) => section.classList.remove("active"));
    // if (formData.lensType === "reading" && type === "manual") {
    //     document.getElementById("readingMagnification").classList.add("active");
    // } 
     if (formData.lensType !== 'non-prescription' && type === 'upload') {
        document.getElementById('uploadPrescription').classList.add('active');
    } else if (formData.lensType !== 'non-prescription' && type === 'manual') {
        document.getElementById('manualPrescription').classList.add('active');
    }
    document.getElementById("prescriptionError").style.display = "none";
    document.getElementById("uploadError").style.display = "none";
    document.getElementById("magnificationError").style.display = "none";
}

function showUploadError(message) {
    const errorElement = document.getElementById("uploadError");
    errorElement.textContent = message;
    errorElement.style.display = "block";
    document.getElementById("uploadSuccess").style.display = "none";
}

async function updateSummary() {
    const frameData = await loadFrameData();
    const framePreview = document.getElementById("framePreview");
    framePreview.innerHTML = `
<img src="${frameData.imageUrl || "https://via.placeholder.com/100"}" alt="${frameData.name || "Frame"
        }">
<div class="frame-preview-details">
  <h3>Selected Frame</h3>
  <p><strong>Frame:</strong> ${frameData.name || "--"}</p>
</div>
`;

    document.getElementById("summary-framePrice").textContent = `Rs ${frameData.price?.toLocaleString() || 0
        }`;
    document.getElementById("summary-lensType").textContent =
        lensTypeLabels[formData.lensType] || "--";
    document.getElementById("summary-features").textContent =
        featureLabels[formData.lensFeature] || "--";
    document.getElementById("summary-lensOption").textContent =
        formData.lensOption || "--";
    document.getElementById("summary-lensPrice").textContent = `Rs ${formData.lensPrice?.toLocaleString() || 0
        }`;
    document.getElementById("summary-totalPrice").textContent = `Rs ${formData.totalPrice?.toLocaleString() || 0
        }`;
//     if (
//         formData.lensType === "reading" &&
//         formData.prescriptionType === "manual"
//     ) {
//         document.getElementById("summary-prescription").innerHTML = `
//   <h3>Prescription Details</h3>
//   <table class="summary-table">
//     <tr><th>Magnification Strength</th><td>${formData.prescription.readingMagnification
//                 ? "+" + formData.prescription.readingMagnification.toFixed(2)
//                 : "--"
//             }</td></tr>
//   </table>
// `;
//     } else if (
//         formData.prescriptionType === "manual" &&
//         formData.lensType !== "non-prescription"
//     ) {
//         document.getElementById("summary-prescription").innerHTML =
//             generatePrescriptionTable();
//     } else {
//         document.getElementById("summary-prescription").innerHTML = "";
//     }
 if (formData.prescriptionType === 'manual' && formData.lensType !== 'non-prescription') {
        document.getElementById('summary-prescription').innerHTML = generatePrescriptionTable();
    } else {
        document.getElementById('summary-prescription').innerHTML = '';
    }
    if (formData.image) {
        document
            .getElementById("summary-imageContainer")
            .classList.remove("hidden");
        document.getElementById("summary-image").src = formData.image;
        document.getElementById("summary-image").style.display = "block";
    } else {
        document
            .getElementById("summary-imageContainer")
            .classList.add("hidden");
    }
}

function generatePrescriptionTable() {
    return `
<h3>Prescription Details</h3>
<table class="summary-table">
  <tr><th></th><th>SPH</th><th>CYL</th><th>Axis</th><th>ADD</th></tr>
  ${generateRow("Right Eye (OD)", formData.prescription.od)}
  ${generateRow("Left Eye (OS)", formData.prescription.os)}
  ${generatePdRow()}
</table>
`;
}

function generateRow(label, data) {
    return `
<tr>
  <td>${label}</td>
  <td>${formatValue(data.sph)}</td>
  <td>${formatValue(data.cyl)}</td>
  <td>${formatValue(data.axis)}</td>
  <td>${formatValue(data.add, "n/a")}</td>
</tr>
`;
}

function formatValue(value, fallback = "--") {
    return value !== null && value !== undefined ? value : fallback;
}

function resetForm() {
    Object.assign(formData, {
        lensType: "",
        lensFeature: "",
        lensOption: "",
        lensPrice: 0,
        totalPrice: 0,
        prescription: {
            od: { sph: null, cyl: null, axis: null, add: null },
            os: { sph: null, cyl: null, axis: null, add: null },
            pd: null,
            pdDual: { right: null, left: null },
            readingMagnification: null,
        },
        image: null,
        prescriptionType: "manual",
    });

    document
        .querySelectorAll(
            'input[name^="od_"], input[name^="os_"], input[id="pd"], input[id="pdRight"], input[id="pdLeft"]'
        )
        .forEach((input) => {
            input.value = "";
        });

    document.getElementById("dualPd").checked = false;
    document.getElementById("dualPdFields").classList.remove("active");

    document.getElementById("imageUpload").value = "";
    document.getElementById("imagePreview").style.display = "none";
    document.getElementById("imagePreview").src = "";
    document.getElementById("uploadSuccess").style.display = "none";

    document
        .querySelectorAll(".magnification-option")
        .forEach((opt) => opt.classList.remove("selected"));

    document
        .querySelectorAll(".cardT")
        .forEach((cardT) => cardT.classList.remove("selected"));

    selectPrescriptionType("manual");

    document.getElementById(`step${currentStep}`).classList.remove("active");
    currentStep = 1;
    totalSteps = 5;
    document.getElementById("step1").classList.add("active");
    updateProgressBar();
    playAudio("step1");
}




