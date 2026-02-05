<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'apply_on',
        'category_id',
        'product_id',
        'user_id',
        'valid_from',
        'valid_until',
        'usage_limit',
        'usage_count',
        'status',
        'meta',
        'show_sale_card',
        'card_color',
        'card_gradient_from',
        'card_gradient_to',
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'meta' => 'array',
        'status' => 'boolean',
    ];

    /*----------------------------------
     | Relationships
     ----------------------------------*/

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    /*----------------------------------
     | Scopes
     ----------------------------------*/

    public function scopeActive($query)
    {
        return $query->where('status', 1)
                     ->where(function($q){
                        $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                     })
                     ->where(function($q){
                        $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                     });
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('valid_until')
                     ->where('valid_until', '<', now());
    }

    /*----------------------------------
     | Helper Methods
     ----------------------------------*/

    public function isExpired()
    {
        if (!$this->valid_until) return false;
        return now()->greaterThan($this->valid_until);
    }

    public function isActive()
    {
        return $this->status === 1 && !$this->isExpired();
    }

    public function hasUsageLeft()
    {
        if ($this->usage_limit === null) {
            return true; // unlimited
        }
        return $this->usage_count < $this->usage_limit;
    }
    public function allowedCustomers()
    {
    return $this->hasMany(CouponCustomer::class);
    }
}
