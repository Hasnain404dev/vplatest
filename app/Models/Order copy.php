<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'session_id',
        'total_amount',
        'coupon_code',
        'discount_amount',
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
}