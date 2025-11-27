@extends('backend.layouts.print')

@section('content')
    <div class="print-header">
        <img src="{{ asset('backend/assets/imgs/theme/logo.svg') }}" alt="Company Logo">
        <h2>Order #{{ $order->order_number }}</h2>
        <p>Date: {{ $order->created_at->format('M j, Y h:i A') }}</p>
    </div>

    <div class="print-section">
        <div style="display: flex; justify-content: space-between; margin-bottom: 3mm;">
            <div style="width: 48%;">
                <h3>Customer Information</h3>
                <div class="compact-row"><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</div>
                <div class="compact-row"><strong>Email:</strong> {{ $order->email }}</div>
                <div class="compact-row"><strong>Phone:</strong> {{ $order->phone }}</div>
                <div class="compact-row">
                    <strong>Address:</strong><br>
                    @if ($order->different_shipping)
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}
                    @else
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->state }} {{ $order->zipcode }}
                    @endif
                </div>
            </div>

            <div style="width: 48%;">
                <h3>Order Information</h3>
                <div class="compact-row"><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
                <div class="compact-row"><strong>Payment Method:</strong> {{ $order->payment_method }}</div>
                <div class="compact-row"><strong>Order Total:</strong> {{ number_format($order->total_amount, 2) }} PKR
                </div>
                @if($order->order_notes)
                    <div class="compact-row"><strong>Customer Notes:</strong> {{ $order->order_notes }}</div>
                @endif
                @if($order->admin_notes)
                    <div class="compact-row"><strong>Admin Notes:</strong> {{ $order->admin_notes }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="print-section">
        <h3>Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th width="40%">Product</th>
                    <th width="15%">Price</th>
                    <th width="10%">Qty</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product ? $item->product->name : 'Product not found' }}</strong>
                            @if($item->color_name)
                                <br><small>Color: {{ $item->color_name }}</small>
                            @endif

                            @if ($item->prescription)
                                <div class="prescription-details">
                                    <strong>Prescription Details:</strong>
                                    <table class="prescription-table">
                                        <tr>
                                            <td width="30%"><strong>Lens Type:</strong></td>
                                            <td>{{ $item->prescription->lens_type }}</td>
                                        </tr>

                                        @if ($item->prescription->prescription_type == 'upload' && $item->prescription->prescription_image)
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Prescription Image:</strong><br>
                                                    <img src="{{ asset($item->prescription->prescription_image) }}"
                                                        style="max-width: 100%; max-height: 50mm; border: 1px solid #ddd; margin-top: 2mm;">
                                                </td>
                                            </tr>
                                        @endif

                                        @if ($item->prescription->prescription_type == 'manual')
                                            @php
                                                $prescriptionData = json_decode($item->prescription->prescription_data, true);
                                            @endphp
                                            @if(isset($prescriptionData['od']))
                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Right Eye (OD):</strong>
                                                        SPH: {{ $prescriptionData['od']['sph'] ?? '' }} |
                                                        CYL: {{ $prescriptionData['od']['cyl'] ?? '' }} |
                                                        AXIS: {{ $prescriptionData['od']['axis'] ?? '' }} |
                                                        ADD: {{ $prescriptionData['od']['add'] ?? '' }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(isset($prescriptionData['os']))
                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Left Eye (OS):</strong>
                                                        SPH: {{ $prescriptionData['os']['sph'] ?? '' }} |
                                                        CYL: {{ $prescriptionData['os']['cyl'] ?? '' }} |
                                                        AXIS: {{ $prescriptionData['os']['axis'] ?? '' }} |
                                                        ADD: {{ $prescriptionData['os']['add'] ?? '' }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if(isset($prescriptionData['pd']))
                                                <tr>
                                                    <td><strong>PD:</strong></td>
                                                    <td>{{ $prescriptionData['pd'] }}</td>
                                                </tr>
                                            @endif
                                        @endif
                                    </table>
                                </div>
                            @endif

                            @if($item->lensesPrescription)
                                <div class="prescription-details">
                                    <strong>Lenses Prescription:</strong>
                                    <table class="prescription-table">
                                        <tr>
                                            <td width="30%"><strong>SPH:</strong></td>
                                            <td>
                                                @if(isset($item->lensesPrescription->sph_right))
                                                    Right: {{ $item->lensesPrescription->sph_right }}<br>
                                                    Left: {{ $item->lensesPrescription->sph_left }}
                                                @else
                                                    {{ $item->lensesPrescription->sph }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if(isset($item->lensesPrescription->cyl))
                                            <tr>
                                                <td><strong>CYL:</strong></td>
                                                <td>{{ $item->lensesPrescription->cyl }}</td>
                                            </tr>
                                        @endif
                                        @if(isset($item->lensesPrescription->axis))
                                            <tr>
                                                <td><strong>AXIS:</strong></td>
                                                <td>{{ $item->lensesPrescription->axis }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            @endif
                        </td>
                        <td>{{ number_format($item->price, 2) }} PKR</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->total, 2) }} PKR</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Grand Total:</th>
                    <th class="text-right">{{ number_format($order->total_amount, 2) }} PKR</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="print-section no-print" style="text-align: center; margin-top: 5mm;">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
        <button onclick="window.close()" class="btn btn-secondary">Close</button>
    </div>
@endsection