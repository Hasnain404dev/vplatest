<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\PaymentMethod;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'session_id',
        'total_amount',
        'payment_method',
        'status',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'address',
        'address2',
        'city',
        'state',
        'zipcode',
        'order_notes',
        'admin_notes',
        'different_shipping',
        'shipping_address',
        'shipping_address2',
        'shipping_city',
        'shipping_state',
        'shipping_zipcode'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // New relationship to get all prescriptions through order items
    public function prescriptions()
    {
        return $this->hasManyThrough(
            Prescription::class,
            OrderItem::class,
            'order_id', // Foreign key on OrderItem table
            'id', // Foreign key on Prescription table
            'id', // Local key on Order table
            'prescription_id' // Local key on OrderItem table
        );
    }

    // New relationship to get all lenses prescriptions through order items
    public function lensesPrescriptions()
    {
        return $this->hasManyThrough(
            LensesPrescription::class,
            OrderItem::class,
            'order_id', // Foreign key on OrderItem table
            'id', // Foreign key on LensesPrescription table
            'id', // Local key on Order table
            'lenses_prescription_id' // Local key on OrderItem table
        );
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Helper method to check if order has payment proof
    public function hasPaymentProof()
    {
        return $this->payment && in_array($this->payment_method, ['jazzcash', 'meezan_bank']);
    }

    // Helper method to check if payment method requires proof
    public function requiresPaymentProof()
    {
        return in_array($this->payment_method, [PaymentMethod::JAZZCASH->value, PaymentMethod::MEEZAN_BANK->value]);
    }

    // Helper method to get payment method enum
    public function getPaymentMethodEnumAttribute()
    {
        return PaymentMethod::tryFrom($this->payment_method);
    }

    // Helper method to get payment method display name
    public function getPaymentMethodDisplayAttribute()
    {
        return match($this->payment_method) {
            'cash_on_delivery' => 'Cash on Delivery',
            'jazzcash' => 'JazzCash',
            'meezan_bank' => 'Meezan Bank',
            default => ucfirst(str_replace('_', ' ', $this->payment_method))
        };
    }

    // Helper method to get payment status
    public function getPaymentStatusAttribute()
    {
        if (!$this->payment) {
            return 'No Payment Record';
        }

        return match($this->payment->method) {
            'cash_on_delivery' => 'Pending (COD)',
            'jazzcash', 'meezan_bank' => $this->payment->transaction_id ? 'Paid (Proof Submitted)' : 'Pending (Proof Required)',
            default => 'Unknown'
        };
    }

    // Scope to filter by payment method
    public function scopeByPaymentMethod($query, PaymentMethod $method)
    {
        return $query->where('payment_method', $method->value);
    }

    // Scope to filter orders requiring payment proof
    public function scopeRequiringPaymentProof($query)
    {
        return $query->whereIn('payment_method', [PaymentMethod::JAZZCASH->value, PaymentMethod::MEEZAN_BANK->value]);
    }

    // Scope to filter COD orders
    public function scopeCashOnDelivery($query)
    {
        return $query->where('payment_method', PaymentMethod::CASH_ON_DELIVERY->value);
    }
}