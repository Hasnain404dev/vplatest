@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Coupon Analytics: {{ $coupon->code }}</h2>
            <p>{{ $coupon->title ?? 'No title' }}</p>
        </div>
        <div>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light btn-sm rounded">
                <i class="material-icons md-arrow_back"></i> Back
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-receipt"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Uses</h6>
                        <span class="h4">{{ $analytics['total_uses'] }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success material-icons md-account_circle"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Unique Users</h6>
                        <span class="h4">{{ $analytics['unique_users'] }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light">
                        <i class="text-warning material-icons md-money_off"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Discount Given</h6>
                        <span class="h4">Rs. {{ number_format($analytics['total_discount'], 2) }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light">
                        <i class="text-info material-icons md-attach_money"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Revenue Generated</h6>
                        <span class="h4">Rs. {{ number_format($analytics['total_revenue'], 2) }}</span>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <!-- Coupon Details -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Coupon Details</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Code:</strong> {{ $coupon->code }}
                </div>
                <div class="col-md-3">
                    <strong>Discount:</strong> 
                    @if($coupon->discount_type === 'percentage')
                        {{ $coupon->discount_value }}%
                    @else
                        Rs. {{ $coupon->discount_value }}
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Status:</strong> 
                    <span class="badge {{ $coupon->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $coupon->status ? 'Active' : 'Disabled' }}
                    </span>
                </div>
                <div class="col-md-3">
                    <strong>Usage:</strong> {{ $coupon->usage_count }} / {{ $coupon->usage_limit ?? '∞' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Usages -->
    <div class="card">
        <div class="card-header">
            <h5>Recent Usages</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Order ID</th>
                            <th>Discount Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($analytics['recent_usages'] as $usage)
                            <tr>
                                <td>{{ $usage->created_at->format('M d, Y H:i') }}</td>
                                <td>{{ $usage->user ? $usage->user->name : 'Guest' }}</td>
                                <td>{{ $usage->order_id ?? 'N/A' }}</td>
                                <td>Rs. {{ number_format($usage->discount_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No usages yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

