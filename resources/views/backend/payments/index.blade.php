@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Payments</h2>
            <p>All submitted payments with proof and COD</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="get" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by order # or transaction id">
                </div>
                <div class="col-md-3">
                    <select name="method" class="form-select">
                        <option value="">All Methods</option>
                        <option value="cash_on_delivery" {{ request('method')==='cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                        <option value="jazzcash" {{ request('method')==='jazzcash' ? 'selected' : '' }}>JazzCash</option>
                        <option value="meezan_bank" {{ request('method')==='meezan_bank' ? 'selected' : '' }}>Meezan Bank</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ request('status')==='verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order #</th>
                            <th>Method</th>
                            <!--<th>Transaction ID</th>-->
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>#{{ $payment->id }}</td>
                                <td>
                                    @if($payment->order)
                                        <a href="{{ route('admin.orders.orderDetail', $payment->order->id) }}">{{ $payment->order->order_number }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $payment->method_display }}</td>
                                <!--<td>{{ $payment->transaction_id ?? '-' }}</td>-->
                                <td>
                                    @php $status = $payment->getRawOriginal('status') ?? 'pending'; @endphp
                                    <span class="badge rounded-pill alert-{{ $status==='verified' ? 'success' : ($status==='rejected' ? 'danger' : 'warning') }}">{{ ucfirst($status) }}</span>
                                </td>
                                <td>{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.payments.show', $payment) }}">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No payments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection


