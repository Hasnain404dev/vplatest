<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-9">
            <div class="content-header d-flex justify-content-between align-items-center">
                <h2 class="content-title">Add New Product</h2>
                <button type="submit" form="productForm" class="btn btn-md rounded font-sm hover-up">Publish</button>
            </div>
        </div>
        <form action="<?php echo e(route('admin.product.store')); ?>" method="POST" enctype="multipart/form-data" id="productForm">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Product Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="name" class="form-label required">Product Name</label>
                                <input type="text" name="name" id="productName"
                                    class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Type here"
                                    required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-4">
                                <label for="slug" class="form-label">Product Slug</label>
                                <input type="text" name="slug" id="productSlug" class="form-control"
                                    placeholder="Will be auto-generated" required>
                                <small class="text-muted">Leave blank to auto-generate from product name</small>
                                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Product Description</label>
                                <textarea name="description" class="form-control" rows="4"
                                    placeholder="Short description for product listing"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Product Long Description</label>
                                <div id="editor" style="height: 300px;"></div>
                                <textarea id="longDescription" name="longDescription" style="display:none;"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Price</label>
                                    <input type="number" name="price" class="form-control" id="productPrice" step="0.01"
                                        min="0" required>
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Discount Price</label>
                                    <input type="number" name="discountprice" class="form-control" id="discountPrice"
                                        step="0.01" min="0">
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Discount %</label>
                                    <input type="number" name="discount" class="form-control" id="discountPercentage"
                                        step="0.01" readonly>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Size</label>
                                    <input type="text" name="size" class="form-control" placeholder="e.g., 50-20-140">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Material</label>
                                    <input type="text" name="material" class="form-control"
                                        placeholder="e.g., Acetate, Metal">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Shape</label>
                                    <input type="text" name="shape" class="form-control" placeholder="e.g., Round, Square">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Rim</label>
                                    <input type="text" name="rim" class="form-control"
                                        placeholder="e.g., Full Rim, Half Rim">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Color</label>
                                    <input type="text" name="color" class="form-control" placeholder="Primary color">
                                </div>

                                <!-- Color variations -->
                                <div id="colorInputs">
                                    <!-- Initial color input fields will be added here -->
                                </div>

                                <div class="col-12 mb-4">
                                    <button type="button" class="btn btn-info" id="addColor">
                                        <i class="fas fa-plus me-1"></i> Add Color Variation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- card end// -->
                </div>
                <div class="col-lg-3">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Categories</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label">Product status</label>
                                <select name="status" class="form-select">
                                    <option value="Featured">Featured</option>
                                    <option value="Popular">Popular</option>
                                    <option value="New">New</option>
                                    <option value="Regular">Regular</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Product Categories</label>
                                <div class="card">
                                    <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-check">
                                                <input class="form-check-input category-checkbox" type="checkbox"
                                                    name="categories[]" value="<?php echo e($category->id); ?>"
                                                    id="category<?php echo e($category->id); ?>"
                                                    data-category-name="<?php echo e(strtolower($category->name)); ?>">
                                                <label class="form-check-label" for="category<?php echo e($category->id); ?>">
                                                    <?php echo e($category->name); ?>

                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                <div class="mb-4 prescription-field" style="display: none;">
                                    <label class="form-label">Lense Prescription Id</label>
                                    <input type="number" name="lenses_prescription_id" class="form-control"
                                        placeholder="Enter prescription ID (1-19)" min="1" max="19"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value > 19) this.value = 19; if(this.value < 1 && this.value != '') this.value = 1;">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control"
                                    placeholder="Comma separated (eyeglasses, sunglasses)">
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Product Images</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Main Image</label>
                                <input type="file" name="main_image" id="mainImage"
                                    class="form-control <?php $__errorArgs = ['main_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*">
                                <small class="text-muted">Primary product image (required, max 2MB)</small>
                                <div class="mt-2">
                                    <img id="mainImagePreview" src="#" alt="Preview"
                                        style="max-width: 100%; max-height: 200px; display: none;" />
                                </div>
                                <?php $__errorArgs = ['main_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>2D Virtual Try-On Image</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">2D Image</label>
                                <input type="file" name="virtual_try_on_image" id="virtualTryOnImage"
                                    class="form-control  <?php $__errorArgs = ['virtual_try_on_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    accept="image/*">
                                <small class="text-muted">Image optimized for virtual try-on feature (max 2MB)</small>
                                <div class="mt-2">
                                    <img id="virtualTryOnPreview" src="#" alt="Virtual Try-On Preview"
                                        style="max-width: 100%; max-height: 200px; display: none;" />
                                </div>
                                <?php $__errorArgs = ['virtual_try_on_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Inventory</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Stock Quantity</label>
                                <input type="number" name="stock" class="form-control" placeholder="Available quantity"
                                    min="0">
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>3D Virtual Try On Name</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">3D Virtual Try On Name</label>
                                <input type="text" name="threeD_try_on_name" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from product name
        document.getElementById('productName').addEventListener('input', function () {
            const nameInput = this;
            const slugInput = document.getElementById('productSlug');

            // Only auto-generate if slug is empty or matches the previous name
            if (!slugInput.value || slugInput.value === slugify(nameInput.previousValue || '')) {
                nameInput.previousValue = nameInput.value;
                slugInput.value = slugify(nameInput.value);
            }
        });

        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        }

        // Preview Main Image
        document.getElementById("mainImage").addEventListener("change", function (event) {
            const input = event.target;
            const preview = document.getElementById("mainImagePreview");

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Preview Virtual Try-On Image
        document.getElementById("virtualTryOnImage").addEventListener("change", function (event) {
            const input = event.target;
            const preview = document.getElementById("virtualTryOnPreview");

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Discount calculation
        function calculateDiscount() {
            const price = parseFloat(document.getElementById('productPrice').value);
            const discountPrice = parseFloat(document.getElementById('discountPrice').value);
            const discountField = document.getElementById('discountPercentage');

            if (!isNaN(price) && !isNaN(discountPrice) && price > 0 && discountPrice <= price) {
                const discount = ((price - discountPrice) / price) * 100;
                discountField.value = discount.toFixed(2);
            } else {
                discountField.value = '';
            }
        }

        document.getElementById('productPrice').addEventListener('input', calculateDiscount);
        document.getElementById('discountPrice').addEventListener('input', calculateDiscount);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const colorInputsContainer = document.getElementById('colorInputs');
            const addColorButton = document.getElementById('addColor');

            // Predefined color options
            const colorOptions = [
                'Black', 'WHITE', 'MATTE BLACK', 'GOLD', 'SILVER',
                'Transparent', 'Mahroon', 'Brown', 'Tortoise', 'Blue',
                'PURPLE', 'gray', 'GREEN', 'PINK', 'SKIN',
                'RED', 'ORANGE', 'YELLOW'
            ];

            // Add first color field by default
            addColorField();

            addColorButton.addEventListener('click', addColorField);

            function addColorField() {
                const colorFieldId = Date.now(); // Unique ID for each field set

                const colorField = document.createElement('div');
                colorField.className = 'color-field-group mb-3 p-3 border rounded';
                colorField.innerHTML = `
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Color Name</label>
                                                        <select name="color_name[]" class="form-select color-select" data-id="${colorFieldId}">
                                                            <option value="">Select a color or type custom</option>
                                                            ${colorOptions.map(color => `<option value="${color}">${color}</option>`).join('')}
                                                            <option value="custom">Custom Color...</option>
                                                        </select>
                                                        <input type="text" name="custom_color_name[]"
                                                               class="form-control mt-2 custom-color-input"
                                                               placeholder="Enter custom color"
                                                               id="custom-color-${colorFieldId}"
                                                               style="display: none;">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Color Image (max 2MB)</label>
                                                        <input type="file" name="color_image[]" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger btn-sm remove-color mt-2">
                                                <i class="fas fa-trash me-1"></i> Remove
                                            </button>
                                        `;

                colorInputsContainer.appendChild(colorField);

                // Add event listener for remove button
                colorField.querySelector('.remove-color').addEventListener('click', function () {
                    colorInputsContainer.removeChild(colorField);
                });

                // Add event listener for color select change
                const selectElement = colorField.querySelector('.color-select');
                selectElement.addEventListener('change', function () {
                    const customInput = colorField.querySelector('.custom-color-input');
                    if (this.value === 'custom') {
                        customInput.style.display = 'block';
                        customInput.required = true;
                    } else {
                        customInput.style.display = 'none';
                        customInput.required = false;
                        customInput.value = '';
                    }
                });
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cache DOM elements
            const checkboxes = document.querySelectorAll('.category-checkbox');
            const prescriptionField = document.querySelector('.prescription-field');

            // Only proceed if elements exist
            if (!prescriptionField || checkboxes.length === 0) return;

            const prescriptionInput = prescriptionField.querySelector('input');

            // Add validation to the input
            if (prescriptionInput) {
                prescriptionInput.addEventListener('input', function () {
                    // Ensure value is between 1-19
                    let value = parseInt(this.value);
                    if (isNaN(value)) {
                        this.value = '';
                    } else {
                        if (value < 1) this.value = 1;
                        if (value > 19) this.value = 19;
                    }
                });
            }

            // Create a single event handler for better performance
            function handleCategoryChange() {
                const lensesChecked = Array.from(checkboxes).some(cb =>
                    cb.checked && cb.dataset.categoryName.toLowerCase().includes('lens')
                );

                // Toggle visibility and requirement
                prescriptionField.style.display = lensesChecked ? 'block' : 'none';

                if (prescriptionInput) {
                    prescriptionInput.required = lensesChecked;
                    // Clear value when hidden
                    if (!lensesChecked) prescriptionInput.value = '';
                }
            }

            // Attach event listeners
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', handleCategoryChange);
            });

            // Initialize state on page load
            handleCategoryChange();
        });
    </script>


    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            // Initialize Quill with formatting options
            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            // When editor content changes, update textarea
            quill.on('text-change', function() {
                document.getElementById('longDescription').value = quill.root.innerHTML;
            });

            // Initialize with existing content
            quill.clipboard.dangerouslyPasteHTML(
                document.getElementById('longDescription').value
            );
        </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\products\create.blade.php ENDPATH**/ ?>