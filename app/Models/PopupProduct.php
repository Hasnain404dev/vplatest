<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopupProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'new_price',
        'old_price',
        'image_path',
        'offer_link',
        'offer_ends_at',
        'is_active',
    ];

    protected $casts = [
        'offer_ends_at' => 'datetime',
        'new_price' => 'decimal:2',
        'old_price' => 'decimal:2',
    ];

    public function getImageUrlAttribute()
    {
        return asset($this->image_path);
    }

    public function getFormattedNewPriceAttribute()
    {
        return number_format($this->new_price, 2);
    }

    public function getFormattedOldPriceAttribute()
    {
        return $this->old_price ? number_format($this->old_price, 2) : null;
    }
}


