<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\User;
use App\Models\Color;
use App\Models\Order;


use App\Models\ContactUs;
use App\Mail\ContactUsMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;


class BaseFrontendController extends Controller
{
    public function __construct()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        View::share('categories', $categories);
    }
}
class FrontendController extends BaseFrontendController
{

    public function account()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('items')->latest()->get();
        $customer = $user->customer; // Assuming you have a customer relationship

        return view('frontend.account', compact('orders', 'customer'));
    }


    public function loginForm()
    {
        return view('frontend.loginPage');
    }


    public function index()
    {
        $sliders = Slider::where('is_active', true)->orderBy('order', 'asc')->get();

        $featuredProducts = Product::with('categories')->where('status', 'featured')->get();
        $popularProducts = Product::with('categories')->where('status', 'popular')->get();
        $newProducts = Product::with('categories')->where('status', 'new')->get();
        $products = Product::with('categories')->get();

        $popupController = new PopupProductController();
        $activePopup = $popupController->getActivePopup();
        return view('frontend.index', compact(
            'sliders',
            'featuredProducts',
            'popularProducts',
            'newProducts',
            'products',
            'activePopup'
        ));
    }

    public function aboutUs()
    {
        return view('frontend.aboutUs');
    }


    public function termsConditions()
    {
        return view('frontend.termsConditions');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacyPolicy');
    }

    public function perchaseGuide()
    {
        return view('frontend.perchaseGuide');
    }

    public function contactUs()
    {
        return view('frontend.contactUs');
    }

    public function shop(Request $request)
    {
        $query = Product::with('categories');

        // Category filtering
        if ($request->has('category') && !empty($request->get('category'))) {
            $categorySlug = $request->get('category');
            $category = Category::where('slug', $categorySlug)->first();

            if ($category) {
                // If type (subcategory) is specified
                if ($request->has('type') && !empty($request->get('type'))) {
                    $typeSlug = $request->get('type');
                    $subcategory = $category->children()->where('slug', $typeSlug)->first();

                    if ($subcategory) {
                        $query->whereHas('categories', function ($q) use ($subcategory) {
                            $q->where('categories.id', $subcategory->id);
                        });
                    }
                } else {
                    // Filter by main category and all its subcategories
                    $categoryIds = $category->children->pluck('id')->push($category->id);
                    $query->whereHas('categories', function ($q) use ($categoryIds) {
                        $q->whereIn('categories.id', $categoryIds);
                    });
                }
            }
        }

        // Sort by status if provided
        if ($request->has('sort') && !empty($request->get('sort'))) {
            $sort = $request->get('sort');

            if ($sort === 'featured') {
                $query->where('status', 'featured');
            } elseif ($sort === 'popular') {
                $query->where('status', 'popular');
            } elseif ($sort === 'new') {
                $query->where('status', 'new');
            } elseif ($sort === 'price_low') {
                $query->orderBy('price', 'asc');
            } elseif ($sort === 'price_high') {
                $query->orderBy('price', 'desc');
            } elseif ($sort === 'date') {
                $query->orderBy('created_at', 'desc');
            }
        }

        // Items per page
        $perPage = 12; // Default
        if ($request->has('show') && in_array($request->get('show'), [50, 100, 150, 200])) {
            $perPage = (int)$request->get('show');
        }

        // Get paginated products
        $products = $query->paginate($perPage)->withQueryString();

        // Get other product collections for the view
        $featuredProducts = Product::with('categories')->where('status', 'featured')->take(8)->get();
        $popularProducts = Product::with('categories')->where('status', 'popular')->take(8)->get();
        $newProducts = Product::with('categories')->where('status', 'new')->take(8)->get();

        // Get categories for sidebar/filtering

        return view('frontend.shop', compact(
            'featuredProducts',
            'popularProducts',
            'newProducts',
            'products',
        ));
    }
    public function productDetail(Product $product, Request $request)
    {
        // Load the product with its relationships
        $product->load(['categories', 'colors']);


        // Get related products from the same categories
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('categories.id', $product->categories->pluck('id'));
        })
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.productDetail', compact('product', 'relatedProducts'));
    }

    public function quickView(Product $product, Request $request)
    {
        // Load the colors relationship
        $product->load(['categories', 'colors']);
        // Check if the request wants JSON
        if ($request->ajax()) {
            // Return the rendered HTML
            $html = view('frontend.partials.quick-view-content', compact('product'))->render();
            return response()->json([
                'html' => $html,
                'success' => true
            ]);
        }

        // If not AJAX, redirect to product page or home
        return redirect()->route('frontend.home');
    }


    // public function search(Request $request)
    // {
    //     try {
    //         $query = $request->query('query');
    //         $categoryId = $request->query('category');

    //         // Log the search parameters
    //         \Log::info('Search request:', [
    //             'query' => $query,
    //             'category' => $categoryId,
    //             'is_ajax' => $request->ajax()
    //         ]);

    //         $products = Product::query()
    //             ->when($query, function ($q) use ($query) {
    //                 $q->where('name', 'like', "%{$query}%");
    //             })
    //             ->when($categoryId, function ($q) use ($categoryId) {
    //                 $q->whereHas('categories', function ($q) use ($categoryId) {
    //                     $q->where('categories.id', $categoryId);
    //                 });
    //             })
    //             ->take(5)
    //             ->get();

    //         // Log the search results
    //         \Log::info('Search results:', [
    //             'count' => $products->count(),
    //             'products' => $products->pluck('name')->toArray()
    //         ]);

    //         if ($request->ajax()) {
    //             $html = view('frontend.partials.search-results', compact('products'))->render();
    //             return response()->json([
    //                 'html' => $html,
    //                 'success' => true,
    //                 'count' => $products->count()
    //             ]);
    //         }

    //         // For non-AJAX requests, redirect to shop page with search parameters
    //         return redirect()->route('frontend.shop', [
    //             'query' => $query,
    //             'category' => $categoryId
    //         ]);
    //     } catch (\Exception $e) {
    //         \Log::error('Search error: ' . $e->getMessage(), [
    //             'exception' => $e,
    //             'request' => $request->all()
    //         ]);

    //         if ($request->ajax()) {
    //             return response()->json([
    //                 'message' => 'An error occurred while searching',
    //                 'error' => $e->getMessage()
    //             ], 500);
    //         }

    //         return redirect()->back()->with('error', 'An error occurred while searching');
    //     }
    // }



    public function search(Request $request)
    {
        try {
            $query = $request->query('query');
            $categoryId = $request->query('category');

            $products = Product::query()
                ->when($query, function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->when($categoryId, function ($q) use ($categoryId) {
                    $q->whereHas('categories', function ($q) use ($categoryId) {
                        $q->where('categories.id', $categoryId);
                    });
                })
                ->with('categories') // Eager load categories if needed
                ->take(5)
                ->get();

            if ($request->ajax()) {
                $html = view('frontend.partials.search-results', compact('products'))->render();
                return response()->json([
                    'html' => $html,
                    'success' => true,
                    'count' => $products->count()
                ]);
            }

            return redirect()->route('frontend.shop', [
                'query' => $query,
                'category' => $categoryId
            ]);
        } catch (\Exception $e) {
            \Log::error('Search error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'An error occurred while searching',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while searching');
        }
    }

    public function orderComplete()
    {
        return view('frontend.orderComplete');
    }


    public function blog()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('frontend.blog', compact('blogs'));
    }
    public function blogDetail(Blog $blog)
    {
        return view('frontend.blogDetail', compact('blog'));
    }


    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email',
            'telephone' => 'nullable|string|max:30',
            'subject'   => 'required|string|max:255',
            'message'   => 'required|string',
        ]);

        // Store in database
        $contact = ContactUs::create($validated);

        // Send email to admin
        Mail::to(config('mail.admin_email'))->send(new ContactUsMessage($contact));

        return back()->with('success', 'Thank you for contacting us!');
    }




    public function underWorking()
    {
        return view('underWorking');
    }
}
