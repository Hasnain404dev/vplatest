<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share categories only with views that need them
        View::composer([
            'frontend.home',
            'frontend.shop*',
            'frontend.product*',
            'frontend.category*',
            'frontend.layouts.app'
        ], function ($view) {
            $categories = Category::with('children')->whereNull('parent_id')->get();
            $view->with('categories', $categories);
        });
    }
}

