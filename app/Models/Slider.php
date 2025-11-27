<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'heading',
        'sub_heading',
        'paragraph',
        'button_name',
        'button_link',
        'order',
        'is_active'
    ];
}
