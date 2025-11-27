@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Payment #{{ $payment->id }}</h2>
            <p>Order: {{ $payment->order?->order_number ?? '-' }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Details</h4>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Method</dt>
                        <dd class="col-sm-8">{{ $payment->method_display }}</dd>

                        <!--<dt class="col-sm-4">Transaction ID</dt>-->
                        <!--<dd class="col-sm-8">{{ $payment->transaction_id ?? '-' }}</dd>-->

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">{{ ucfirst($payment->status ?? 'pending') }}</dd>

                        <dt class="col-sm-4">Submitted At</dt>
                        <dd class="col-sm-8">{{ $payment->created_at->format('Y-m-d H:i') }}</dd>

                        <dt class="col-sm-4">Verified At</dt>
                        <dd class="col-sm-8">{{ $payment->verified_at ? $payment->verified_at->format('Y-m-d H:i') : '-' }}</dd>

                        <dt class="col-sm-4">Admin Notes</dt>
                        <dd class="col-sm-8">{{ $payment->admin_notes ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            @if($payment->screenshot_url)
                <div class="card mb-4">
                    <div class="card-header"><h4>Payment Screenshot</h4></div>
                    <div class="card-body">
                        <a href="{{ $payment->screenshot_url }}" target="_blank">
                            <img src="{{ $payment->screenshot_url }}" alt="screenshot" class="img-fluid rounded border" style="max-height:480px">
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h4>Update Status</h4></div>
                <div class="card-body">
                    <form method="post" action="{{ route('admin.payments.updateStatus', $payment) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $payment->status==='pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verified" {{ $payment->status==='verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ $payment->status==='rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="4" placeholder="Optional notes">{{ old('admin_notes', $payment->admin_notes) }}</textarea>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


