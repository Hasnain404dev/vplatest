<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'longDescription',
        'price',
        'discountprice',
        'discount',
        'size',
        'color',
        'material',
        'status',
        'shape',
        'rim',
        'category',
        'lenses_prescription_id',
        'tags',
        'stock',
        'main_image',
        'virtual_try_on_image',
        'slug', // Added slug field
        'threeD_try_on_name',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
    public function colors()
    {
        return $this->hasMany(Color::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

     public function lensesPrescriptions()
    {
        return $this->hasMany(LensesPrescription::class);
    }

}
