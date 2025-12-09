@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Edit Bulk Discount</h2>
        </div>
        <div>
            <a href="{{ route('admin.bulk-discounts.index') }}" class="btn btn-light btn-sm rounded">
                <i class="material-icons md-arrow_back"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.bulk-discounts.update', $discount->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $discount->title) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Type *</label>
                        <select name="discount_type" class="form-select" required>
                            <option value="percentage" {{ old('discount_type', $discount->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="fixed" {{ old('discount_type', $discount->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Discount Value *</label>
                        <input type="number" name="discount_value" class="form-control" 
                               value="{{ old('discount_value', $discount->discount_value) }}" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Scope *</label>
                        <select name="scope" class="form-select" required id="scope">
                            <option value="all" {{ old('scope', $discount->scope) == 'all' ? 'selected' : '' }}>All Products</option>
                            <option value="category" {{ old('scope', $discount->scope) == 'category' ? 'selected' : '' }}>By Category</option>
                            <option value="products" {{ old('scope', $discount->scope) == 'products' ? 'selected' : '' }}>Selected Products</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="category_field" style="display:none;">
                        <label class="form-label">Select Categories *</label>
                        <select name="category_ids[]" class="form-select" multiple size="5">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ in_array($category->id, old('category_ids', $discount->scope_meta['category_ids'] ?? [])) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="product_field" style="display:none;">
                        <label class="form-label">Select Products *</label>
                        <select name="product_ids[]" class="form-select" multiple size="10">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        {{ in_array($product->id, old('product_ids', $discount->scope_meta['product_ids'] ?? [])) ? 'selected' : '' }}>
                                    {{ $product->name }} - Rs. {{ $product->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Starts At</label>
                        <input type="datetime-local" name="starts_at" class="form-control" 
                               value="{{ old('starts_at', $discount->starts_at ? $discount->starts_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ends At</label>
                        <input type="datetime-local" name="ends_at" class="form-control" 
                               value="{{ old('ends_at', $discount->ends_at ? $discount->ends_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" 
                                   {{ old('active', $discount->active) ? 'checked' : '' }}>
                            <label class="form-check-label">Active</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Discount</button>
                    <a href="{{ route('admin.bulk-discounts.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $('#scope').on('change', function() {
        const value = $(this).val();
        $('#category_field').toggle(value === 'category');
        $('#product_field').toggle(value === 'products');
    }).trigger('change');
</script>
@endpush

