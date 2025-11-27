@if($products->count())
    <div class="search-results-container">
        @foreach($products as $product)
            <div class="search-result-item p-3 border-bottom hover-bg-light">
                <div class="d-flex align-items-center">
                    <a href="{{ route('frontend.productDetail', $product->slug) }}">
                        <div class="product-image-wrapper me-3"
                            style="width: 70px; height: 70px; overflow: hidden; border-radius: 8px;">
                            @if($product->main_image)
                                <img src="{{ asset('uploads/products/' . $product->main_image) }}" alt="{{ $product->name }}"
                                    class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="product-info-wrapper flex-grow-1">
                            <h6 class="text-center product-title mb-1 text-dark">{{ $product->name }}</h6>
                            <div class="product-price mb-2">
                                @if($product->discountprice && $product->discountprice < $product->price)
                                    <span class="text-center fw-bold text-danger">Rs
                                        {{ number_format($product->discountprice, 2) }}</span>
                                    <span class="text-center text-decoration-line-through text-muted small ms-2">Rs
                                        {{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="text-center fw-bold">Rs {{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="no-results-found p-4 text-center">
        <i class="fas fa-search text-muted mb-2" style="font-size: 2rem;"></i>
        <p class="text-muted mb-0">No products found</p>
    </div>
@endif