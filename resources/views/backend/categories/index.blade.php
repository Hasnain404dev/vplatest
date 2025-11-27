@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
            <h2 class="content-title card-title">Category List</h2>
            <div class="">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="material-icons md-add"></i> Add Category
                </button>
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

    <!-- Create Category Modal -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">Create New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent Category (Optional)</label>
                            <select class="form-select" id="parent_id" name="parent_id">
                                <option value="">-- No Parent --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Display Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Parent Category</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->children->count() > 0)
                                        <span class="badge bg-info ms-2">{{ $category->children->count() }} subcategories</span>
                                    @endif
                                </td>
                                <td>{{ $category->parent ? $category->parent->name : '--' }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                           class="btn btn-sm font-sm btn-primary rounded">
                                            <i class="material-icons md-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this category? All subcategories will also be deleted!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm font-sm btn-danger rounded">
                                                <i class="material-icons md-delete_forever"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Display subcategories if they exist -->
                            @if($category->children->count() > 0)
                                @foreach($category->children as $child)
                                    <tr class="bg-light">
                                        <td></td>
                                        <td>↳ {{ $child->name }}</td>
                                        <td>{{ $child->parent->name }}</td>
                                        <td>{{ $child->slug }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.categories.edit', $child->id) }}" 
                                                   class="btn btn-sm font-sm btn-primary rounded">
                                                    <i class="material-icons md-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $child->id) }}" method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm font-sm btn-danger rounded">
                                                        <i class="material-icons md-delete_forever"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No categories found. Create your first category!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // If there are validation errors, show the modal automatically
    @if($errors->any())
        $(document).ready(function() {
            $('#createCategoryModal').modal('show');
        });
    @endif
</script>
@endpush