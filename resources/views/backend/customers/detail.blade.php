@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Customer Detail</h2>
            <p>Customer ID: #{{ $customer->id }}</p>
        </div>
        {{-- <div>
            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary">Edit Customer</a>
        </div> --}}
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-xl-8 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5>Basic Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <div class="form-control-plaintext">{{ $customer->first_name }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <div class="form-control-plaintext">{{ $customer->last_name }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-plaintext">{{ $customer->email }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <div class="form-control-plaintext">{{ $customer->phone }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company</label>
                                    <div class="form-control-plaintext">{{ $customer->company_name ?: 'N/A' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Registered Date</label>
                                    <div class="form-control-plaintext">{{ $customer->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5>Address Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address</label>
                                    <div class="form-control-plaintext">{{ $customer->address ?: 'N/A' }}</div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Address 2</label>
                                    <div class="form-control-plaintext">{{ $customer->address2 ?: 'N/A' }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">City</label>
                                    <div class="form-control-plaintext">{{ $customer->city ?: 'N/A' }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">State</label>
                                    <div class="form-control-plaintext">{{ $customer->state ?: 'N/A' }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Zipcode</label>
                                    <div class="form-control-plaintext">{{ $customer->zipcode ?: 'N/A' }}</div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Country</label>
                                    <div class="form-control-plaintext">{{ $customer->country ?: 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total Orders</span>
                                <span class="text-primary">{{ $customer->orders ? $customer->orders->count() : 0 }}</span>
                            </div>
                            @if($customer->orders && $customer->orders->count() > 0)
                                @php
                                    $totalSpent = $customer->orders->sum('total_amount');
                                    $latestOrder = $customer->orders->sortByDesc('created_at')->first();
                                @endphp
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Total Spent</span>
                                    <span class="text-primary">{{ number_format($totalSpent, 2) }} PKR</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Latest Order</span>
                                    <span class="text-primary">{{ $latestOrder->created_at->format('d M Y') }}</span>
                                </div>
                            @else
                                <div class="alert alert-info">No orders found for this customer.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5>Order History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders ?? [] as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>{{ number_format($order->total_amount, 2) }} PKR</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'alert-warning',
                                                    'processing' => 'alert-info',
                                                    'completed' => 'alert-success',
                                                    'cancelled' => 'alert-danger',
                                                ][$order->status ?? 'pending'];
                                            @endphp
                                            <span class="badge rounded-pill {{ $statusClass }}">
                                                {{ ucfirst($order->status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.orders.orderDetail', $order->id) }}" class="btn btn-sm btn-light">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
