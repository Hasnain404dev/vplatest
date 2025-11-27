@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Wishlist
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table shopping-summery text-center">
                                <thead>
                                    <tr class="main-heading">
                                        <th scope="col" colspan="2">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Stock Status</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($wishlistItems->count() > 0)
                                        @foreach ($wishlistItems as $item)
                                            <tr>
                                                <td class="image product-thumbnail">
                                                    <img src="{{ asset('uploads/products/' . $item->product->main_image) }}"
                                                        alt="{{ $item->product->name }}">
                                                </td>
                                                <td class="product-des product-name">
                                                    <h5 class="product-name">
                                                        <a
                                                            href="{{ route('frontend.productDetail', $item->product) }}">{{ $item->product->name }}</a>
                                                    </h5>
                                                    <p class="font-xs">
                                                        {{ $item->product->categories->pluck('name')->implode(', ') }}
                                                    </p>
                                                </td>
                                                <td class="price" data-title="Price">
                                                    <span>{{ $item->product->discountprice ?? $item->product->price }}</span>
                                                    @if ($item->product->discountprice)
                                                        <span class="old-price text-decoration-line-through text-muted">{{ $item->product->price }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center" data-title="Stock">
                                                    <span
                                                        class="color3 font-weight-bold">{{ $item->product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                                                </td>
                                                <td class="text-right" data-title="Cart">
                                                    <form action="{{ route('frontend.wishlist.moveToCart', $item) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm">
                                                            <i class="fi-rs-shopping-bag mr-5"></i>Add to cart
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="action" data-title="Remove">
                                                    <form action="{{ route('frontend.removeFromWishList', $item) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-remove">
                                                            <i class="fi-rs-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <h4>Your wishlist is empty</h4>
                                                <p>Explore our products and add items to your wishlist</p>
                                                <a href="{{ route('frontend.shop') }}" class="btn btn-fill-out">Continue
                                                    Shopping</a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
