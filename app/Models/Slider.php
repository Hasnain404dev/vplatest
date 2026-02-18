<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'image_desktop',
        'image_mobile',
        'heading',
        'sub_heading',
        'paragraph',
        'heading_color',
        'sub_heading_color',
        'paragraph_color',
        'button_name',
        'button_link',
        'button_text_color',
        'button_bg_color',
        'background_opacity',
        'text_color',
        'button_color',
        'order',
        'is_active'
    ];

    protected $casts = [
        'background_opacity' => 'float',
    ];
}
