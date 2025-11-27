@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="content-title card-title">Edit Category</h2>
            <div>
                <a href="{{ route('admin.categories') }}" class="btn btn-secondary">
                    <i class="material-icons md-arrow_back"></i> Back to Categories
                </a>
            </div>
        </div>
    </div>

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

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $category->name) }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="slug" class="form-label">Slug (URL)</label>
                            <input type="text" class="form-control" id="slug" name="slug" 
                                   value="{{ old('slug', $category->slug) }}" required>
                            <small class="text-muted">Leave blank to auto-generate from name</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="parent_id" class="form-label">Parent Category</label>
                            <select class="form-select" id="parent_id" name="parent_id">
                                <option value="">-- No Parent (Top Level) --</option>
                                @foreach($parentCategories as $parent)
                                    @if($parent->id != $category->id) {{-- Prevent self-parenting --}}
                                        <option value="{{ $parent->id }}" 
                                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                            
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal">
                                <i class="material-icons md-delete_forever"></i> Delete Category
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
                    @if($category->children->count() > 0)
                        <div class="alert alert-warning">
                            <strong>Warning!</strong> This category has {{ $category->children->count() }} subcategories that will also be deleted.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        if (!document.getElementById('slug').value) {
            const slug = this.value.toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special chars
                .replace(/[\s_-]+/g, '-')   // Replace spaces and underscores with -
                .replace(/^-+|-+$/g, '');   // Trim - from start and end
            document.getElementById('slug').value = slug;
        }
    });
</script>
@endpush