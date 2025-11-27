@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Customers List</h2>
        <div>
            <a href="{{ route('admin.customers.export') }}" class="btn btn-light rounded font-md">Export</a>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <div class="row gx-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <form action="{{ route('admin.customersData') }}" method="GET">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ request('search') }}" />
                    </form>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <form action="{{ route('admin.customersData') }}" method="GET" id="statusForm">
                        <select class="form-select" name="status" onchange="document.getElementById('statusForm').submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </form>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <form action="{{ route('admin.customersData') }}" method="GET" id="perPageForm">
                        <select class="form-select" name="show" onchange="document.getElementById('perPageForm').submit()">
                            <option value="20" {{ request('show') == 20 ? 'selected' : '' }}>Show 20</option>
                            <option value="30" {{ request('show') == 30 ? 'selected' : '' }}>Show 30</option>
                            <option value="40" {{ request('show') == 40 ? 'selected' : '' }}>Show 40</option>
                        </select>
                    </form>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Orders</th>
                            <th>Registered</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td width="30%">
                                    <a href="{{ route('admin.customers.detail', $customer->id) }}" class="itemside">
                                        {{-- <div class="left">
                                            <img src="{{ asset('backend/assets/imgs/people/avatar-default.jpg') }}" class="img-sm img-avatar"
                                                alt="Customer Avatar" />
                                        </div> --}}
                                        <div class="info pl-3">
                                            <h6 class="mb-0 title">{{ $customer->first_name }} {{ $customer->last_name }}</h6>
                                            <small class="text-muted">Customer ID: #{{ $customer->id }}</small>
                                        </div>
                                    </a>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>
                                    {{ $customer->city }}, {{ $customer->country }}
                                </td>
                                <td>
                                    @php
                                        $orderCount = $customer->orders ? $customer->orders->count() : 0;
                                    @endphp
                                    <span class="badge rounded-pill {{ $orderCount > 0 ? 'alert-success' : 'alert-warning' }}">
                                        {{ $orderCount }} orders
                                    </span>
                                </td>
                                <td>{{ $customer->created_at->format('d.m.Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.customers.detail', $customer->id) }}" class="btn btn-sm btn-brand rounded font-sm">View details</a>
                                    <div class="dropdown">
                                        <a href="#" data-bs-toggle="dropdown" class="btn btn-light rounded btn-sm font-sm">
                                            <i class="material-icons md-more_horiz"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.customers.detail', $customer->id) }}">View details</a>
                                            <form action="{{ route('admin.customers.delete', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')">
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
                                <td colspan="7" class="text-center">No customers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- table-responsive.// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    <div class="pagination-area mt-15 mb-50">
        {{ $customers->links() }}
    </div>
@endsection

