@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('frontend.home') }}" rel="nofollow">Home</a>
                    <span></span> Pages
                    <span></span> Account
                </div>
            </div>
        </div>
        <section class="pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                                                href="#dashboard" role="tab" aria-controls="dashboard"
                                                aria-selected="false"><i
                                                    class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                                role="tab" aria-controls="orders" aria-selected="false"><i
                                                    class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address"
                                                role="tab" aria-controls="address" aria-selected="true"><i
                                                    class="fi-rs-marker mr-10"></i>My Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();  document.getElementById('logout-form').submit();"><i
                                                    class="fi-rs-sign-out mr-10"></i>Logout</a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="tab-content dashboard-content">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                        aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Hello {{ auth()->user()->name }}!</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>Account Information</h6>
                                                        <p>
                                                            <strong>Name:</strong> {{ $customer->first_name ?? '' }}
                                                            {{ $customer->last_name ?? '' }}<br>
                                                            <strong>Email:</strong> {{ auth()->user()->email }}<br>
                                                            <strong>Phone:</strong> {{ $customer->phone ?? 'Not provided' }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>Default Address</h6>
                                                        @if ($customer)
                                                            <address>
                                                                {{ $customer->address }}<br>
                                                                @if ($customer->address2)
                                                                    {{ $customer->address2 }}<br>
                                                                @endif
                                                                {{ $customer->city }}, {{ $customer->state }}<br>
                                                                {{ $customer->zipcode }}<br>
                                                                {{ $customer->country }}
                                                            </address>
                                                        @else
                                                            <p>No address information saved.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="mt-3">From your account dashboard. you can easily check &amp;
                                                    view your <a href="#orders">recent orders</a> and <a href="#">edit
                                                        your account details.</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Your Orders</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order #</th>
                                                                <th>Date</th>
                                                                <th>Items</th>
                                                                <th>Total</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($orders as $order)
                                                                <tr>
                                                                    <td>{{ $order->order_number }}</td>
                                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                                    <td>{{ $order->items->sum('quantity') }}</td>
                                                                    <td>{{ number_format($order->total_amount, 2) }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                                            {{ ucfirst($order->status) }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">You have no
                                                                        orders yet.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Billing Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        @if ($customer)
                                                            <address>
                                                                <strong>{{ $customer->first_name }}
                                                                    {{ $customer->last_name }}</strong><br>
                                                                @if ($customer->company_name)
                                                                    {{ $customer->company_name }}<br>
                                                                @endif
                                                                {{ $customer->address }}<br>
                                                                @if ($customer->address2)
                                                                    {{ $customer->address2 }}<br>
                                                                @endif
                                                                {{ $customer->city }}, {{ $customer->state }}<br>
                                                                {{ $customer->zipcode }}<br>
                                                                {{ $customer->country }}<br>
                                                                <strong>Phone:</strong> {{ $customer->phone }}<br>
                                                                <strong>Email:</strong> {{ auth()->user()->email }}
                                                            </address>
                                                            <a href=""
                                                                class="btn-small">Edit Information</a>
                                                        @else
                                                            <p>No billing information saved.</p>
                                                            <a href=""
                                                                class="btn-small">Add Information</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Shipping Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        @if ($customer && $customer->shipping_address)
                                                            <address>
                                                                <strong>{{ $customer->shipping_first_name ?? $customer->first_name }}
                                                                    {{ $customer->shipping_last_name ?? $customer->last_name }}</strong><br>
                                                                {{ $customer->shipping_address }}<br>
                                                                @if ($customer->shipping_address2)
                                                                    {{ $customer->shipping_address2 }}<br>
                                                                @endif
                                                                {{ $customer->shipping_city }},
                                                                {{ $customer->shipping_state }}<br>
                                                                {{ $customer->shipping_zipcode }}<br>
                                                                {{ $customer->shipping_country ?? $customer->country }}
                                                            </address>
                                                            <a href=""
                                                                class="btn-small">Edit Information</a>
                                                        @elseif($customer)
                                                            <p>Same as billing address</p>
                                                            <a href=""
                                                                class="btn-small">Add Different Shipping Address</a>
                                                        @else
                                                            <p>No shipping information saved.</p>
                                                            <a href=""
                                                                class="btn-small">Add Information</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
