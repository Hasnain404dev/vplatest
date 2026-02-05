@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Bulk Discount Management</h2>
            <p>Apply discounts to multiple products or categories at once</p>
        </div>
        <div>
            <a href="{{ route('admin.bulk-discounts.create') }}" class="btn btn-primary btn-sm rounded">
                <i class="material-icons md-add"></i> Create Bulk Discount
            </a>
        </div>
    </div>

    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.bulk-discounts.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by title..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.bulk-discounts.index') }}" class="btn btn-light">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Discounts Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Discount</th>
                            <th>Scope</th>
                            <th>Valid Period</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discounts as $discount)
                            <tr>
                                <td>
                                    <strong>{{ $discount->title ?? 'Untitled Discount' }}</strong>
                                </td>
                                <td>
                                    @if($discount->discount_type === 'percentage')
                                        <span class="badge bg-info">{{ $discount->discount_value }}%</span>
                                    @else
                                        <span class="badge bg-info">Rs. {{ $discount->discount_value }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($discount->scope === 'all')
                                        <span class="badge bg-primary">All Products</span>
                                    @elseif($discount->scope === 'category')
                                        <span class="badge bg-secondary">Categories</span>
                                    @elseif($discount->scope === 'products')
                                        <span class="badge bg-secondary">Selected Products</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($discount->scope) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($discount->starts_at && $discount->ends_at)
                                        <small>
                                            {{ $discount->starts_at->format('M d, Y') }}<br>
                                            to {{ $discount->ends_at->format('M d, Y') }}
                                        </small>
                                    @else
                                        <span class="text-muted">No expiry</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input toggle-status" type="checkbox" 
                                               data-id="{{ $discount->id }}"
                                               {{ $discount->active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.bulk-discounts.edit', $discount->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="material-icons md-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.bulk-discounts.destroy', $discount->id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure? This will remove discounts from all affected products.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="material-icons md-delete_forever"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No bulk discounts found. Create your first one!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($discounts->hasPages())
                <div class="mt-4">
                    {{ $discounts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle status
    $(document).on('change', '.toggle-status', function() {
        const discountId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/bulk-discounts/${discountId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                }
            },
            error: function() {
                toastr.error('Error updating status');
            }
        });
    });
</script>
@endpush

