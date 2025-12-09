<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCustomer extends Model
{
    use HasFactory;

    protected $table = 'coupon_customers';

    protected $fillable = ['coupon_id', 'user_id', 'phone_number', 'email'];

    public $timestamps = true;

    // Relationships
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}