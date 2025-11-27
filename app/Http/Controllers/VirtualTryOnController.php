<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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

class VirtualTryOnController extends BaseFrontendController
{
    public function index(Product $product)
    {
        // Verify the image exists in public/uploads/products
        $imagePath = public_path('uploads/products/' . $product->main_image);
        if (!file_exists($imagePath)) {
            abort(404, 'Product image not found at: ' . $imagePath);
        }

        // Verify virtual try-on image exists
        if (!$product->virtual_try_on_image) {
            abort(404, 'This product does not support virtual try-on');
        }

        $tryOnImagePath = public_path('uploads/products/virtual_try_on/' . $product->virtual_try_on_image);
        if (!file_exists($tryOnImagePath)) {
            abort(404, 'Virtual try-on image not found at: ' . $tryOnImagePath);
        }

        return view('virtual-try-on.index', compact('product'));
    }

    public function threeDTryOn(Product $product)
    {
        // Verify that the product has a 3D try-on name
        if (!$product->threeD_try_on_name) {
            abort(404, 'This product does not support 3D virtual try-on');
        }

        return view('virtual-try-on.treeDTryOn', compact('product'));
    }
}
