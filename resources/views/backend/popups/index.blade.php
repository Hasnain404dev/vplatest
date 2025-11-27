@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div class="w-50">
                <h2 class="content-title card-title">Popup List</h2>
            </div>
            <div class="w-50 text-end">
                <a href="{{ route('admin.popups.create') }}" class="btn btn-primary">Add New Popup</a>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>New Price</th>
                            <th>Old Price</th>
                            <th>Status</th>
                            <th>Expires At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($popupProducts as $popup)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $popup->image_url }}" class="img-thumbnail"
                                        style="width: 60px; height: 60px; object-fit: cover;" alt="Popup Image">
                                </td>
                                <td><strong>{{ $popup->title }}</strong></td>
                                <td>{{ $popup->formatted_new_price }} PKR</td>
                                <td>{{ $popup->formatted_old_price ?? 'N/A' }} PKR</td>
                                <td>
                                    <span
                                        class="badge rounded-pill {{ $popup->is_active == 1 ? 'alert-success' : 'alert-danger' }}">
                                        {{ $popup->is_active == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $popup->offer_ends_at->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-light rounded btn-sm font-sm" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="material-icons md-more_horiz"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('popup-products.edit', $popup->id) }}">Edit</a>
                                            <form action="{{ route('popup-products.destroy', $popup->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No popup products found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-area mt-15 mb-50">
                {{ $popupProducts->links() }}
            </div>
        </div>
    </div>
@endsection

