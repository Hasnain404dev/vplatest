<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\PaymentMethod;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'method',
        'transaction_id',
        'screenshot_path',
        'status',
        'admin_notes',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Helper method to get payment method enum
    public function getMethodEnumAttribute()
    {
        return PaymentMethod::tryFrom($this->method);
    }

    // Helper method to get payment method display name
    public function getMethodDisplayAttribute()
    {
        return match($this->method) {
            'cash_on_delivery' => 'Cash on Delivery',
            'jazzcash' => 'JazzCash',
            'meezan_bank' => 'Meezan Bank',
            default => ucfirst(str_replace('_', ' ', $this->method))
        };
    }

    // Helper method to check if payment has proof
    public function hasProof()
    {
        return in_array($this->method, ['jazzcash', 'meezan_bank']) && 
               !empty($this->transaction_id) && 
               !empty($this->screenshot_path);
    }

    // Helper method to get screenshot URL
    public function getScreenshotUrlAttribute()
    {
        if (!$this->screenshot_path) {
            return null;
        }

        // If stored directly under public/ (e.g., payments/filename)
        if (str_starts_with($this->screenshot_path, 'payments/')) {
            return asset($this->screenshot_path);
        }

        // Fallbacks for previous formats
        if (str_starts_with($this->screenshot_path, 'storage/')) {
            return asset($this->screenshot_path);
        }
        if (str_starts_with($this->screenshot_path, 'uploads/')) {
            return asset('storage/' . $this->screenshot_path);
        }
        return asset($this->screenshot_path);
    }

    // Helper method to get payment status
    public function getStatusAttribute()
    {
        if ($this->method === 'cash_on_delivery') {
            return 'Pending (COD)';
        }

        if (in_array($this->method, ['jazzcash', 'meezan_bank'])) {
            if ($this->hasProof()) {
                return 'Paid (Proof Submitted)';
            } else {
                return 'Pending (Proof Required)';
            }
        }

        return 'Unknown';
    }

    // Scope to filter by payment method
    public function scopeByMethod($query, $method)
    {
        return $query->where('method', $method);
    }

    // Scope to filter payments with proof
    public function scopeWithProof($query)
    {
        return $query->whereIn('method', ['jazzcash', 'meezan_bank'])
                    ->whereNotNull('transaction_id')
                    ->whereNotNull('screenshot_path');
    }

    // Scope to filter payments without proof
    public function scopeWithoutProof($query)
    {
        return $query->whereIn('method', ['jazzcash', 'meezan_bank'])
                    ->where(function($q) {
                        $q->whereNull('transaction_id')
                          ->orWhereNull('screenshot_path');
                    });
    }

    // Helper method to check if payment is verified
    public function isVerified()
    {
        return $this->status === 'verified';
    }

    // Helper method to check if payment is pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Helper method to check if payment is rejected
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Scope to filter by status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // Scope to filter verified payments
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    // Scope to filter pending payments
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope to filter rejected payments
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}


