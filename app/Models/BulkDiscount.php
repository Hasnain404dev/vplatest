<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'discount_type',
        'discount_value',
        'scope',
        'scope_meta',
        'active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'scope_meta' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'active' => 'boolean',
    ];

    /*----------------------------------
     | Scopes
     ----------------------------------*/

    public function scopeActive($query)
    {
        return $query->where('active', 1)
            ->where(function($q){
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function($q){
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }
}
