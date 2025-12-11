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
                <h2 class="content-title">Edit Product</h2>
                <button type="submit" form="productForm" class="btn btn-md rounded font-sm hover-up">Update</button>
            </div>
        </div>
        <form action="<?php echo e(route('admin.product.update', $product->id)); ?>" method="POST" enctype="multipart/form-data"
            id="productForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Product Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="name" id="productName" class="form-control"
                                    value="<?php echo e(old('name', $product->name)); ?>" placeholder="Type here" required>
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
                                    value="<?php echo e(old('slug', $product->slug)); ?>" placeholder="Will be auto-generated" required>
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
                                <textarea name="description" class="form-control" rows="4" placeholder="Short description for product listing"><?php echo e(old('description', $product->description)); ?></textarea>
                            </div>
                           <div class="mb-4">
                                <label class="form-label">Product Long Description</label>
                                <!-- Quill Editor Container -->
                                <div id="editor"><?php echo old('longDescription', $product->longDescription); ?></div>
                                <!-- Hidden textarea that will store the HTML -->
                                <textarea name="longDescription" id="longDescription" style="display:none;">
                                    <?php echo e(old('longDescription', $product->longDescription)); ?>

                                </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Price</label>
                                    <input type="number" name="price" class="form-control" id="productPrice"
                                        step="0.01" min="0" value="<?php echo e(old('price', $product->price)); ?>" required>
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Discount Price</label>
                                    <input type="number" name="discountprice" class="form-control" id="discountPrice"
                                        step="0.01" min="0"
                                        value="<?php echo e(old('discountprice', $product->discountprice)); ?>">
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Discount %</label>
                                    <input type="number" name="discount" class="form-control" id="discountPercentage"
                                        step="0.01" value="<?php echo e(old('discount', $product->discount)); ?>" readonly>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Size</label>
                                    <input type="text" name="size" class="form-control"
                                        value="<?php echo e(old('size', $product->size)); ?>" placeholder="e.g., 50-20-140">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Color</label>
                                    <input type="text" name="color" class="form-control"
                                        value="<?php echo e(old('color', $product->color)); ?>" placeholder="Primary color">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Material</label>
                                    <input type="text" name="material" class="form-control"
                                        value="<?php echo e(old('material', $product->material)); ?>"
                                        placeholder="e.g., Acetate, Metal">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Shape</label>
                                    <input type="text" name="shape" class="form-control"
                                        value="<?php echo e(old('shape', $product->shape)); ?>" placeholder="e.g., Round, Square">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Rim</label>
                                    <input type="text" name="rim" class="form-control"
                                        value="<?php echo e(old('rim', $product->rim)); ?>" placeholder="e.g., Full Rim, Half Rim">
                                </div>
                            </div>
                        </div>
                    </div> <!-- card end// -->

                    <!-- Color Variations Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Color Variations</h4>
                        </div>
                        <div class="card-body">
                            <div id="colorInputs">
                                <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="color-field-group mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Color Name</label>
                                                    <select name="existing_color_name[<?php echo e($color->id); ?>]"
                                                        class="form-select color-select" data-id="<?php echo e($color->id); ?>">
                                                        <option value="">Select a color or type custom</option>
                                                        <?php $__currentLoopData = ['Black', 'WHITE', 'MATTE BLACK', 'GOLD', 'SILVER', 'Transparent', 'Mahroon', 'Brown', 'Tortoise', 'Blue', 'PURPLE', 'gray', 'GREEN', 'PINK', 'SKIN', 'RED', 'ORANGE', 'YELLOW']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colorOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($colorOption); ?>"
                                                                <?php echo e(old("existing_color_name.$color->id", $color->color_name) == $colorOption ? 'selected' : ''); ?>>
                                                                <?php echo e($colorOption); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="custom"
                                                            <?php echo e(!in_array($color->color_name, [
                                                                'Black',
                                                                'WHITE',
                                                                'MATTE BLACK',
                                                                'GOLD',
                                                                'SILVER',
                                                                'Transparent',
                                                                'Mahroon',
                                                                'Brown',
                                                                'Tortoise',
                                                                'Blue',
                                                                'PURPLE',
                                                                'gray',
                                                                'GREEN',
                                                                'PINK',
                                                                'SKIN',
                                                                'RED',
                                                                'ORANGE',
                                                                'YELLOW',
                                                            ])
                                                                ? 'selected'
                                                                : ''); ?>>
                                                            Custom Color...</option>
                                                    </select>
                                                    <input type="text"
                                                        name="existing_custom_color_name[<?php echo e($color->id); ?>]"
                                                        class="form-control mt-2 custom-color-input"
                                                        placeholder="Enter custom color"
                                                        id="custom-color-<?php echo e($color->id); ?>"
                                                        value="<?php echo e(!in_array($color->color_name, [
                                                            'Black',
                                                            'WHITE',
                                                            'MATTE BLACK',
                                                            'GOLD',
                                                            'SILVER',
                                                            'Transparent',
                                                            'Mahroon',
                                                            'Brown',
                                                            'Tortoise',
                                                            'Blue',
                                                            'PURPLE',
                                                            'gray',
                                                            'GREEN',
                                                            'PINK',
                                                            'SKIN',
                                                            'RED',
                                                            'ORANGE',
                                                            'YELLOW',
                                                        ])
                                                            ? old("existing_color_name.$color->id", $color->color_name)
                                                            : ''); ?>"
                                                        style="<?php echo e(in_array($color->color_name, [
                                                            'Black',
                                                            'WHITE',
                                                            'MATTE BLACK',
                                                            'GOLD',
                                                            'SILVER',
                                                            'Transparent',
                                                            'Mahroon',
                                                            'Brown',
                                                            'Tortoise',
                                                            'Blue',
                                                            'PURPLE',
                                                            'gray',
                                                            'GREEN',
                                                            'PINK',
                                                            'SKIN',
                                                            'RED',
                                                            'ORANGE',
                                                            'YELLOW',
                                                        ])
                                                            ? 'display: none;'
                                                            : ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Color Image</label>
                                                    <input type="file"
                                                        name="existing_color_image[<?php echo e($color->id); ?>]"
                                                        class="form-control">
                                                    <?php if($color->image): ?>
                                                        <div class="mt-2">
                                                            <img src="<?php echo e(asset('uploads/products/colors/' . $color->image)); ?>"
                                                                alt="<?php echo e($color->color_name); ?>" style="max-width: 100px;">
                                                            <input type="hidden"
                                                                name="existing_color_image_old[<?php echo e($color->id); ?>]"
                                                                value="<?php echo e($color->image); ?>">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm remove-color mt-2"
                                            data-color-id="<?php echo e($color->id); ?>">Remove</button>
                                        <input type="hidden" name="existing_color_ids[]" value="<?php echo e($color->id); ?>">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <button type="button" class="btn btn-info" id="addColor">
                                <i class="fas fa-plus me-1"></i> Add New Color
                            </button>
                        </div>
                    </div>
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
                                    <option value="Featured"
                                        <?php echo e(old('status', $product->status) == 'Featured' ? 'selected' : ''); ?>>Featured
                                    </option>
                                    <option value="Popular"
                                        <?php echo e(old('status', $product->status) == 'Popular' ? 'selected' : ''); ?>>Popular
                                    </option>
                                    <option value="New"
                                        <?php echo e(old('status', $product->status) == 'New' ? 'selected' : ''); ?>>New</option>
                                    <option value="Regular"
                                        <?php echo e(old('status', $product->status) == 'Regular' ? 'selected' : ''); ?>>Regular
                                    </option>
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
                                                    data-category-name="<?php echo e(strtolower($category->name)); ?>"
                                                    <?php echo e(in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : ''); ?>>
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
                                        value="<?php echo e(old('lenses_prescription_id', $product->lenses_prescription_id ?? '')); ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control"
                                    value="<?php echo e(old('tags', $product->tags)); ?>"
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
                                <small class="text-muted">Primary product image (max 2MB)</small>
                                <?php if($product->main_image): ?>
                                    <div class="mt-2">
                                        <img id="mainImagePreview"
                                            src="<?php echo e(asset('uploads/products/' . $product->main_image)); ?>"
                                            alt="Current Image" style="max-width: 100%; max-height: 200px;" />
                                        <input type="hidden" name="main_image_old" value="<?php echo e($product->main_image); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="mt-2">
                                        <img id="mainImagePreview" src="#" alt="Preview"
                                            style="max-width: 100%; max-height: 200px; display: none;" />
                                    </div>
                                <?php endif; ?>
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
                                    class="form-control <?php $__errorArgs = ['virtual_try_on_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    accept="image/*">
                                <small class="text-muted">Image optimized for virtual try-on feature (max 2MB)</small>
                                <?php if($product->virtual_try_on_image): ?>
                                    <div class="mt-2">
                                        <img id="virtualTryOnPreview"
                                            src="<?php echo e(asset('uploads/products/virtual_try_on/' . $product->virtual_try_on_image)); ?>"
                                            alt="Current Virtual Try-On Image"
                                            style="max-width: 100%; max-height: 200px;" />
                                        <input type="hidden" name="virtual_try_on_image_old"
                                            value="<?php echo e($product->virtual_try_on_image); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="mt-2">
                                        <img id="virtualTryOnPreview" src="#" alt="Preview"
                                            style="max-width: 100%; max-height: 200px; display: none;" />
                                    </div>
                                <?php endif; ?>
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
                                <input type="number" name="stock" class="form-control"
                                    value="<?php echo e(old('stock', $product->stock)); ?>" placeholder="Available quantity"
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
                                <input type="text" name="threeD_try_on_name" class="form-control"
                                    value="<?php echo e(old('threeD_try_on_name', $product->threeD_try_on_name)); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from product name
        document.getElementById('productName').addEventListener('input', function() {
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
        document.getElementById("mainImage").addEventListener("change", function(event) {
            const input = event.target;
            const preview = document.getElementById("mainImagePreview");

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Preview Virtual Try-On Image
        document.getElementById("virtualTryOnImage").addEventListener("change", function(event) {
            const input = event.target;
            const preview = document.getElementById("virtualTryOnPreview");

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
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

        document.addEventListener('DOMContentLoaded', function() {
            const colorInputsContainer = document.getElementById('colorInputs');
            const addColorButton = document.getElementById('addColor');

            // Predefined color options
            const colorOptions = [
                'Black', 'WHITE', 'MATTE BLACK', 'GOLD', 'SILVER',
                'Transparent', 'Mahroon', 'Brown', 'Tortoise', 'Blue',
                'PURPLE', 'gray', 'GREEN', 'PINK', 'SKIN',
                'RED', 'ORANGE', 'YELLOW'
            ];

            // Handle existing color select changes
            document.querySelectorAll('.color-select').forEach(select => {
                select.addEventListener('change', function() {
                    const colorId = this.getAttribute('data-id');
                    const customInput = document.getElementById(`custom-color-${colorId}`);
                    if (this.value === 'custom') {
                        customInput.style.display = 'block';
                        customInput.required = true;
                    } else {
                        customInput.style.display = 'none';
                        customInput.required = false;
                        customInput.value = '';
                    }
                });
            });

            // Add new color field
            addColorButton.addEventListener('click', function() {
                const colorFieldId = Date.now();

                const colorField = document.createElement('div');
                colorField.className = 'color-field-group mb-3 p-3 border rounded';
                colorField.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Color Name</label>
                            <select name="new_color_name[]" class="form-select new-color-select" data-id="${colorFieldId}">
                                <option value="">Select a color or type custom</option>
                                ${colorOptions.map(color => `<option value="${color}">${color}</option>`).join('')}
                                <option value="custom">Custom Color...</option>
                            </select>
                            <input type="text" name="new_custom_color_name[]"
                                   class="form-control mt-2 new-custom-color-input"
                                   placeholder="Enter custom color"
                                   id="new-custom-color-${colorFieldId}"
                                   style="display: none;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Color Image</label>
                            <input type="file" name="new_color_image[]" class="form-control" required>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-color mt-2">
                    <i class="fas fa-trash me-1"></i> Remove
                </button>
            `;

                colorInputsContainer.appendChild(colorField);

                // Add event listener for remove button
                colorField.querySelector('.remove-color').addEventListener('click', function() {
                    colorInputsContainer.removeChild(colorField);
                });

                // Add event listener for color select change
                const selectElement = colorField.querySelector('.new-color-select');
                selectElement.addEventListener('change', function() {
                    const customInput = colorField.querySelector('.new-custom-color-input');
                    if (this.value === 'custom') {
                        customInput.style.display = 'block';
                        customInput.required = true;
                    } else {
                        customInput.style.display = 'none';
                        customInput.required = false;
                        customInput.value = '';
                    }
                });
            });

            // Remove existing color fields
            document.querySelectorAll('.remove-color[data-color-id]').forEach(button => {
                button.addEventListener('click', function() {
                    const colorId = this.getAttribute('data-color-id');
                    const colorField = this.closest('.color-field-group');

                    // Add a hidden input to mark this color for deletion
                    const deleteInput = document.createElement('input');
                    deleteInput.type = 'hidden';
                    deleteInput.name = 'deleted_color_ids[]';
                    deleteInput.value = colorId;
                    colorInputsContainer.appendChild(deleteInput);

                    // Remove the color field
                    colorInputsContainer.removeChild(colorField);
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');
            const prescriptionField = document.querySelector('.prescription-field');
            const prescriptionInput = prescriptionField.querySelector('input');

            // Function to check if any lens category is selected
            function checkLensCategories() {
                return Array.from(checkboxes).some(cb =>
                    cb.checked && cb.dataset.categoryName.includes('lens')
                );
            }

            // Function to toggle prescription field
            function togglePrescriptionField() {
                const showField = checkLensCategories();
                prescriptionField.style.display = showField ? 'block' : 'none';
                prescriptionInput.required = showField;
            }

            // Add event listeners
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', togglePrescriptionField);
            });

            // Initialize on page load
            togglePrescriptionField();

            // Input validation
            prescriptionInput.addEventListener('input', function() {
                let value = parseInt(this.value);
                if (!isNaN(value)) {
                    if (value < 1) this.value = 1;
                    if (value > 19) this.value = 19;
                }
            });
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

<?php echo $__env->make('backend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\visionPlus\visionPlus-new\vplatest\resources\views\backend\products\edit.blade.php ENDPATH**/ ?>