@if ($popup)
    <div class="deal" style="background-image: url('{{ asset($popup->image_path) }}');">
        <div class="deal-top">
            <h2 class="text-brand">{{ $popup->title }}</h2>
            <h5>{{ $popup->description }}</h5>
        </div>
        <div class="deal-content">
            <div class="product-price">
                <span class="new-price fw-bold">Just {{ $popup->formatted_new_price }} PKR!</span>
                @if ($popup->old_price)
                    <span class="old-price fw-bold">{{ $popup->formatted_old_price }}/-</span>
                @endif
            </div>
        </div>
        <div class="deal-bottom">
            <p>Hurry Up! Offer End In:</p>
            <div class="deals-countdown" data-countdown="{{ $popup->offer_ends_at->format('Y/m/d H:i:s') }}"></div>
            <a href="{{ $popup->offer_link }}" class="btn hover-up">Shop Now <i class="fi-rs-arrow-right"></i></a>
        </div>
    </div>
@else
    <div class="text-center py-4">
        <p>No active promotions at the moment.</p>
    </div>
@endif
