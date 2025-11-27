@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Reviews Management</h2>
            <p>Manage customer product reviews</p>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <input type="text" placeholder="Search..." class="form-control" id="searchInput">
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </header>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td><b>{{ $review->product->name }}</b></td>
                                <td>{{ $review->name }}<br><small>{{ $review->email }}</small></td>
                                <td>
                                    <ul class="rating-stars">
                                        <li style="width: {{ $review->rating * 20 }}%" class="stars-active">
                                            <img src="/backend/assets/imgs/icons/stars-active.svg" alt="stars" />
                                        </li>
                                        <li>
                                            <img src="/backend/assets/imgs/icons/starts-disable.svg" alt="stars" />
                                        </li>
                                    </ul>
                                </td>
                                <td>{{ Str::limit($review->comment, 50) }}</td>
                                <td>
                                    @if($review->images->count() > 0)
                                        <div class="review-images">
                                            @foreach($review->images->take(3) as $image)
                                                <a href="{{ asset('uploads/reviews/' . $image->image) }}" target="_blank" class="me-1">
                                                    <img src="{{ asset('uploads/reviews/' . $image->image) }}"
                                                         alt="Review Image"
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                </a>
                                            @endforeach
                                            @if($review->images->count() > 3)
                                                <span class="badge bg-secondary">+{{ $review->images->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">No Images</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $review->status == 'approved' ? 'success' : ($review->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($review->status) }}
                                    </span>
                                </td>
                                <td>{{ $review->created_at->format('d.m.Y') }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm">
                                            <i class="material-icons md-more_horiz"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <form action="{{ route('admin.reviews.update-status', $review) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="dropdown-item">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.reviews.update-status', $review) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="dropdown-item">Reject</button>
                                            </form>
                                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-area mt-15 mb-50">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Simple search functionality
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Status filter
        $("#statusFilter").on("change", function() {
            var value = $(this).val().toLowerCase();
            if (value === "") {
                $("table tbody tr").show();
            } else {
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).find("td:nth-child(7)").text().toLowerCase().indexOf(value) > -1)
                });
            }
        });
    });
</script>
@endsection



