<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\View;

class BaseFrontendController extends Controller
{
    public function __construct()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        View::share('categories', $categories);
    }
}

