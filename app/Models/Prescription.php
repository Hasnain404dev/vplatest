<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'lens_type',
        'lens_feature',
        'lens_option',
        'lens_price',
        'total_price',
        'prescription_type',
        'prescription_data',
        'image_uploaded',
        'prescription_image',
        'status'
    ];

    protected $casts = [
        'lens_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'prescription_data' => 'array',
        'image_uploaded' => 'boolean',
    ];

    /**
     * Get the user that owns the prescription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the prescription.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the formatted lens price.
     */
    public function getFormattedLensPriceAttribute()
    {
        return 'Rs ' . number_format($this->lens_price, 2);
    }

    /**
     * Get the formatted total price.
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rs ' . number_format($this->total_price, 2);
    }

    /**
     * Get the right eye prescription data.
     */
    public function getRightEyeAttribute()
    {
        if (!isset($this->prescription_data['rightEye'])) {
            return null;
        }
        return $this->prescription_data['rightEye'];
    }

    /**
     * Get the left eye prescription data.
     */
    public function getLeftEyeAttribute()
    {
        if (!isset($this->prescription_data['leftEye'])) {
            return null;
        }
        return $this->prescription_data['leftEye'];
    }

    /**
     * Get the pupillary distance data.
     */
    public function getPdAttribute()
    {
        if (!isset($this->prescription_data['pupillaryDistance'])) {
            return null;
        }
        return $this->prescription_data['pupillaryDistance'];
    }
}

