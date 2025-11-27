@extends('frontend.layouts.app')


@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span> Shop
                    <span></span> Order Complete
                </div>
            </div>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fi-rs-check-circle text-success" style="font-size: 50px;"></i>
                                    <h2 class="mt-3">Thank You For Your Order!</h2>
                                    <p class="mb-4">Your order has been placed successfully.</p>
                                    <a href="{{ route('frontend.home') }}" class="btn btn-fill-out">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

