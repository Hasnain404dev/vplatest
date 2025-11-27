@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Order List</h2>
            <p>All orders in the system</p>
        </div>
        <div>
            <form action="{{ route('admin.orders') }}" method="GET">
                <input type="text" name="search" placeholder="Search order ID" class="form-control bg-white" value="{{ request('search') }}">
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <form action="{{ route('admin.orders') }}" method="GET">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ request('search') }}">
                    </form>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <form action="{{ route('admin.orders') }}" method="GET" id="statusForm">
                        <select class="form-select" name="status" onchange="document.getElementById('statusForm').submit()">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <form action="{{ route('admin.orders') }}" method="GET" id="perPageForm">
                        <select class="form-select" name="show" onchange="document.getElementById('perPageForm').submit()">
                            <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>Show 20</option>
                            <option value="30" {{ request('show') == 30 ? 'selected' : '' }}>Show 30</option>
                            <option value="40" {{ request('show') == 40 ? 'selected' : '' }}>Show 40</option>
                        </select>
                    </form>
                </div>
            </div>
        </header> <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Total</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td><b>{{ $order->first_name }} {{ $order->last_name }}</b></td>
                                <td>{{ $order->email }}</td>
                                <td>{{ number_format($order->total_amount, 2) }} PKR</td>
                                <td>{{ $order->payment_method }}</td>
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
                                <td>{{ $order->created_at->format('d.m.Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.orderDetail', $order->id) }}" class="btn btn-md rounded font-sm">Detail</a>
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm">
                                            <i class="material-icons md-more_horiz"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.orders.orderDetail', $order->id) }}">View detail</a>
                                            <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div> <!-- dropdown //end -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> <!-- table-responsive //end -->
        </div> <!-- card-body end// -->
    </div> <!-- card end// -->
    <div class="pagination-area mt-15 mb-50">
        {{ $orders->links() }}
    </div>
@endsection

