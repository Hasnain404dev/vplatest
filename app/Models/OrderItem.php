<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'color_name',
        'price',
        'total',
        'prescription_id',
        'lenses_prescription_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Corrected prescription relationship
    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }

    // Corrected lenses prescription relationship
    public function lensesPrescription()
    {
        return $this->belongsTo(LensesPrescription::class, 'lenses_prescription_id');
    }
}