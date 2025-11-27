@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-9">
            <div class="content-header d-flex justify-content-between align-items-center">
                <h2 class="content-title">Edit Product</h2>
                <button type="submit" form="productForm" class="btn btn-md rounded font-sm hover-up">Update</button>
            </div>
        </div>
        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            id="productForm">
            @csrf
            @method('PUT')
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
                                    value="{{ old('name', $product->name) }}" placeholder="Type here" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="slug" class="form-label">Product Slug</label>
                                <input type="text" name="slug" id="productSlug" class="form-control"
                                    value="{{ old('slug', $product->slug) }}" placeholder="Will be auto-generated" required>
                                <small class="text-muted">Leave blank to auto-generate from product name</small>
                                @error('slug')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Product Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Short description for product listing">{{ old('description', $product->description) }}</textarea>
                            </div>
                           <div class="mb-4">
                                <label class="form-label">Product Long Description</label>
                                <!-- Quill Editor Container -->
                                <div id="editor">{!! old('longDescription', $product->longDescription) !!}</div>
                                <!-- Hidden textarea that will store the HTML -->
                                <textarea name="longDescription" id="longDescription" style="display:none;">
                                    {{ old('longDescription', $product->longDescription) }}
                                </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Price</label>
                                    <input type="number" name="price" class="form-control" id="productPrice"
                                        step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Discount Price</label>
                                    <input type="number" name="discountprice" class="form-control" id="discountPrice"
                                        step="0.01" min="0"
                                        value="{{ old('discountprice', $product->discountprice) }}">
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Discount %</label>
                                    <input type="number" name="discount" class="form-control" id="discountPercentage"
                                        step="0.01" value="{{ old('discount', $product->discount) }}" readonly>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Size</label>
                                    <input type="text" name="size" class="form-control"
                                        value="{{ old('size', $product->size) }}" placeholder="e.g., 50-20-140">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Color</label>
                                    <input type="text" name="color" class="form-control"
                                        value="{{ old('color', $product->color) }}" placeholder="Primary color">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Material</label>
                                    <input type="text" name="material" class="form-control"
                                        value="{{ old('material', $product->material) }}"
                                        placeholder="e.g., Acetate, Metal">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Shape</label>
                                    <input type="text" name="shape" class="form-control"
                                        value="{{ old('shape', $product->shape) }}" placeholder="e.g., Round, Square">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Product Rim</label>
                                    <input type="text" name="rim" class="form-control"
                                        value="{{ old('rim', $product->rim) }}" placeholder="e.g., Full Rim, Half Rim">
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
                                @foreach ($product->colors as $color)
                                    <div class="color-field-group mb-3 p-3 border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Color Name</label>
                                                    <select name="existing_color_name[{{ $color->id }}]"
                                                        class="form-select color-select" data-id="{{ $color->id }}">
                                                        <option value="">Select a color or type custom</option>
                                                        @foreach (['Black', 'WHITE', 'MATTE BLACK', 'GOLD', 'SILVER', 'Transparent', 'Mahroon', 'Brown', 'Tortoise', 'Blue', 'PURPLE', 'gray', 'GREEN', 'PINK', 'SKIN', 'RED', 'ORANGE', 'YELLOW'] as $colorOption)
                                                            <option value="{{ $colorOption }}"
                                                                {{ old("existing_color_name.$color->id", $color->color_name) == $colorOption ? 'selected' : '' }}>
                                                                {{ $colorOption }}
                                                            </option>
                                                        @endforeach
                                                        <option value="custom"
                                                            {{ !in_array($color->color_name, [
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
                                                                : '' }}>
                                                            Custom Color...</option>
                                                    </select>
                                                    <input type="text"
                                                        name="existing_custom_color_name[{{ $color->id }}]"
                                                        class="form-control mt-2 custom-color-input"
                                                        placeholder="Enter custom color"
                                                        id="custom-color-{{ $color->id }}"
                                                        value="{{ !in_array($color->color_name, [
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
                                                            : '' }}"
                                                        style="{{ in_array($color->color_name, [
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
                                                            : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Color Image</label>
                                                    <input type="file"
                                                        name="existing_color_image[{{ $color->id }}]"
                                                        class="form-control">
                                                    @if ($color->image)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('uploads/products/colors/' . $color->image) }}"
                                                                alt="{{ $color->color_name }}" style="max-width: 100px;">
                                                            <input type="hidden"
                                                                name="existing_color_image_old[{{ $color->id }}]"
                                                                value="{{ $color->image }}">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm remove-color mt-2"
                                            data-color-id="{{ $color->id }}">Remove</button>
                                        <input type="hidden" name="existing_color_ids[]" value="{{ $color->id }}">
                                    </div>
                                @endforeach
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
                                        {{ old('status', $product->status) == 'Featured' ? 'selected' : '' }}>Featured
                                    </option>
                                    <option value="Popular"
                                        {{ old('status', $product->status) == 'Popular' ? 'selected' : '' }}>Popular
                                    </option>
                                    <option value="New"
                                        {{ old('status', $product->status) == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Regular"
                                        {{ old('status', $product->status) == 'Regular' ? 'selected' : '' }}>Regular
                                    </option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Product Categories</label>
                                <div class="card">
                                    <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                        @foreach ($categories as $category)
                                            <div class="form-check">
                                                <input class="form-check-input category-checkbox" type="checkbox"
                                                    name="categories[]" value="{{ $category->id }}"
                                                    id="category{{ $category->id }}"
                                                    data-category-name="{{ strtolower($category->name) }}"
                                                    {{ in_array($category->id, old('categories', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="category{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4 prescription-field" style="display: none;">
                                    <label class="form-label">Lense Prescription Id</label>
                                    <input type="number" name="lenses_prescription_id" class="form-control"
                                        placeholder="Enter prescription ID (1-19)" min="1" max="19"
                                        value="{{ old('lenses_prescription_id', $product->lenses_prescription_id ?? '') }}">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control"
                                    value="{{ old('tags', $product->tags) }}"
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
                                    class="form-control @error('main_image') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Primary product image (max 2MB)</small>
                                @if ($product->main_image)
                                    <div class="mt-2">
                                        <img id="mainImagePreview"
                                            src="{{ asset('uploads/products/' . $product->main_image) }}"
                                            alt="Current Image" style="max-width: 100%; max-height: 200px;" />
                                        <input type="hidden" name="main_image_old" value="{{ $product->main_image }}">
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <img id="mainImagePreview" src="#" alt="Preview"
                                            style="max-width: 100%; max-height: 200px; display: none;" />
                                    </div>
                                @endif
                                @error('main_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                                    class="form-control @error('virtual_try_on_image') is-invalid @enderror"
                                    accept="image/*">
                                <small class="text-muted">Image optimized for virtual try-on feature (max 2MB)</small>
                                @if ($product->virtual_try_on_image)
                                    <div class="mt-2">
                                        <img id="virtualTryOnPreview"
                                            src="{{ asset('uploads/products/virtual_try_on/' . $product->virtual_try_on_image) }}"
                                            alt="Current Virtual Try-On Image"
                                            style="max-width: 100%; max-height: 200px;" />
                                        <input type="hidden" name="virtual_try_on_image_old"
                                            value="{{ $product->virtual_try_on_image }}">
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <img id="virtualTryOnPreview" src="#" alt="Preview"
                                            style="max-width: 100%; max-height: 200px; display: none;" />
                                    </div>
                                @endif
                                @error('virtual_try_on_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
                                    value="{{ old('stock', $product->stock) }}" placeholder="Available quantity"
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
                                    value="{{ old('threeD_try_on_name', $product->threeD_try_on_name) }}">
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
@endsection
