<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensesPrescription extends Model
{
    use HasFactory;

    protected $table = 'lenses_prescriptions';

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'sph_right',
        'sph_left',
        'sph',
        'cyl',
        'axis',
        'quantity',
        'total_price'
    ];

    /**
     * Get the user associated with the prescription.
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
        return $this->belongsTo(Product::class);
    }
}
