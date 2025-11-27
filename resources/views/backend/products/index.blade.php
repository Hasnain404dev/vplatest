@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Products List</h2>
            {{-- <p>Lorem ipsum dolor sit amet.</p> --}}
        </div>
        <div>
            {{-- <a href="#" class="btn btn-light rounded font-md">Export</a> --}}
            {{-- <a href="#" class="btn btn-light rounded  font-md">Import</a> --}}
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm rounded">Create new</a>
        </div>
    </div>
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-md-2 col-6">
                    <form action="{{ route('admin.products') }}" method="GET" id="dateFilterForm">
                        <input type="date" name="date_filter" class="form-control"
                            value="{{ request('date_filter', date('Y-m-d')) }}" onchange="this.form.submit()">
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                    </form>
                </div>
                 <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <form action="{{ route('admin.products') }}" method="GET" class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search product name"
                            value="{{ request('search') }}">
                        <button class="btn btn-light bg" type="submit">
                            <i class="material-icons md-search"></i>
                        </button>
                        {{-- Keep other filters if needed --}}
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if (request('date_filter'))
                            <input type="hidden" name="date_filter" value="{{ request('date_filter') }}">
                        @endif
                    </form>
                </div>
                <div class="col-md-2 col-6">
                    <form action="{{ route('admin.products') }}" method="GET">
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="">All Products</option>
                            <option value="Featured" {{ request('status') == 'Featured' ? 'selected' : '' }}>Featured</option>
                            <option value="Popular" {{ request('status') == 'Popular' ? 'selected' : '' }}>Popular</option>
                            <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>New</option>

                        </select>
                    </form>
                </div>
            </div>
        </header> <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col"><input type="checkbox"></th>
                            <th scope="col">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Discount Price</th>
                            <th scope="col">Statud</th>
                            <th scope="col">Tags</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    @if ($product->main_image)
                                        <img src="{{ asset('uploads/products/' . $product->main_image) }}" class="img-thumbnail"
                                            width="60" alt="Product Image">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }} PKR</td>
                                <td>{{ $product->discountprice }} PKR</td>
                                <td>
                                    <span class="badge bg-success">{{ $product->status }}</span>
                                </td>
                                <td>{{ $product->tags }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                        <i class="material-icons md-edit"></i>
                                    </a>

                                    @if ($product->virtual_try_on_image)
                                        <a href="{{ route('virtual.try.on', $product->slug) }}" class="btn btn-sm btn-primary">
                                            <i class="material-icons md-camera_front"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.product.delete', $product->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="material-icons md-delete_forever"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div> <!-- card end// -->
    <div class="pagination-area mt-30 mb-50">
        {{ $products->links() }}
    </div>
@endsection