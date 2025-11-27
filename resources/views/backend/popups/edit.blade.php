@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="w-50">
                <h2 class="content-title card-title">Edit Popup</h2>
            </div>
            <div class="w-50 text-end">
                <a href="{{ route('admin.popups') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('popup-products.update', $popupProduct->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="title" class="form-label">Popup Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $popupProduct->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" required>{{ old('description', $popupProduct->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="new_price" class="form-label">New Price (PKR)</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('new_price') is-invalid @enderror" id="new_price"
                                    name="new_price" value="{{ old('new_price', $popupProduct->new_price) }}" required>
                                @error('new_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="old_price" class="form-label">Old Price (PKR)</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('old_price') is-invalid @enderror" id="old_price"
                                    name="old_price" value="{{ old('old_price', $popupProduct->old_price) }}">
                                @error('old_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="offer_link" class="form-label">Offer Link</label>
                            <input type="url" class="form-control @error('offer_link') is-invalid @enderror"
                                id="offer_link" name="offer_link"
                                value="{{ old('offer_link', $popupProduct->offer_link) }}" required>
                            @error('offer_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="offer_ends_at" class="form-label">Offer Ends At</label>
                            <input type="datetime-local" class="form-control @error('offer_ends_at') is-invalid @enderror"
                                id="offer_ends_at" name="offer_ends_at"
                                value="{{ old('offer_ends_at', $popupProduct->offer_ends_at->format('Y-m-d\TH:i')) }}"
                                required>
                            @error('offer_ends_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    @checked(old('is_active', $popupProduct->is_active))>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            <small class="form-text text-muted">
                                When active, this popup will be shown to users who visit the site.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Popup Image</h4>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <img id="image-preview" src="{{ $popupProduct->image_url }}" alt="Current Image"
                                        class="w-100 mb-3" style="width: 100%; height: auto;">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image" onchange="previewImage(this)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Leave empty to keep current image</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-3">
                    <button type="submit" class="btn btn-primary btn-lg">Update Popup</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

