@extends('frontend.layouts.prescriptionApp')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 lenspres-image-container">
                <div class="eyeframe-details">
                    <img id="main-product-image" src="{{ asset('uploads/products/' . $product->main_image) }}"
                        alt="{{ $product->name }}" class="thumbnail" width="50%"  loading="lazy" decoding="async">
                    <div class="eyeframe-name">{{ $product->name }}</div>
                    <div class="eyeframe-price">
                        @if ($product->discountprice)
                            <span>Rs. {{ $product->discountprice }}</span>
                            <span class="old-price text-decoration-line-through text-muted">Rs. {{ $product->price }}</span>
                        @else
                            <span>Rs. {{ $product->price }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 lenspres-container">
                <div id="lens-product-price">Price: PKR {{ $product->discountprice ?? $product->price }}</div>
                <div id="lens-prescription-form"></div>
                <button class="pre-cart" onclick="addToCart()">Submit</button>
            </div>
        </div>

    </div>

    <script>
        const currentProductId = {{ $product->id }};
        const baseProductPrice = {{ $product->discountprice ?? $product->price }};
        const lensesPrescriptionId = {{ $product->lenses_prescription_id }};

        // ✅ Call function with correct ID
        document.addEventListener("DOMContentLoaded", () => {
            loadProductPrescription(lensesPrescriptionId);
        });
    </script>


    <script src="{{ asset('frontend/assets/js/lensesPrescription.js') }}"></script>
@endsection
