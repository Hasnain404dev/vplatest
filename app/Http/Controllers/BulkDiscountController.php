<?php

namespace App\Http\Controllers;

use App\Models\BulkDiscount;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BulkDiscountController extends Controller
{
    /**
     * Display a listing of bulk discounts
     */
    public function index(Request $request)
    {
        $query = BulkDiscount::latest();

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('active', 1)
                      ->where(function($q) {
                          $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                      })
                      ->where(function($q) {
                          $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
                      });
            } elseif ($request->status === 'inactive') {
                $query->where('active', 0);
            }
        }

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $discounts = $query->paginate(20)->withQueryString();

        return view('backend.bulk-discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new bulk discount
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        
        return view('backend.bulk-discounts.create', compact('categories', 'products'));
    }

    /**
     * Store a newly created bulk discount
     */
    public function store(Request $request)
    {
        \Log::info('BulkDiscount store request received', ['input' => $request->all()]);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'scope' => 'required|in:all,category,brand,products',
            'category_ids' => 'nullable|array|required_if:scope,category',
            'category_ids.*' => 'exists:categories,id',
            'product_ids' => 'nullable|array|required_if:scope,products',
            'product_ids.*' => 'exists:products,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'active' => 'nullable',
        ]);

        // Build scope_meta
        $scopeMeta = [];
        if ($request->scope === 'category' && $request->filled('category_ids')) {
            $scopeMeta['category_ids'] = $request->category_ids;
        } elseif ($request->scope === 'products' && $request->filled('product_ids')) {
            $scopeMeta['product_ids'] = $request->product_ids;
        } elseif ($request->scope === 'brand' && $request->filled('brand_ids')) {
            $scopeMeta['brand_ids'] = $request->brand_ids;
        }

        $validated['scope_meta'] = !empty($scopeMeta) ? $scopeMeta : null;
        $validated['starts_at'] = $request->starts_at ? Carbon::parse($request->starts_at) : null;
        $validated['ends_at'] = $request->ends_at ? Carbon::parse($request->ends_at) : null;
        $validated['active'] = $request->has('active') ? 1 : 0;

        \Log::info('BulkDiscount validated data', ['validated' => $validated]);

        try {
            DB::transaction(function () use (&$discount, $validated) {
                $discount = BulkDiscount::create($validated);
            });
        } catch (\Exception $e) {
            \Log::error('BulkDiscount create failed', ['error' => $e->getMessage(), 'data' => $validated]);
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create bulk discount: ' . $e->getMessage()]);
        }

        if (!$discount) {
            \Log::error('BulkDiscount creation returned null instance');
            return redirect()->back()->withInput()->withErrors(['error' => 'Bulk discount was not created.']);
        }

        \Log::info('BulkDiscount created successfully', ['id' => $discount->id]);

        try {
            // Override existing discounts on creation to ensure application
            $this->applyDiscountToProducts($discount, true);
            \Log::info('BulkDiscount applied to products', ['discount_id' => $discount->id]);
        } catch (\Exception $e) {
            \Log::error('BulkDiscount application to products failed', ['error' => $e->getMessage(), 'discount_id' => $discount->id]);
            return redirect()->route('admin.bulk-discounts.index')
                ->with('success', 'Bulk discount created, but product application failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.bulk-discounts.index')
            ->with('success', 'Bulk discount created and applied successfully!');
    }

    /**
     * Show the form for editing a bulk discount
     */
    public function edit($id)
    {
        $discount = BulkDiscount::findOrFail($id);
        $categories = Category::all();
        $products = Product::all();

        return view('backend.bulk-discounts.edit', compact('discount', 'categories', 'products'));
    }

    /**
     * Update a bulk discount
     */
    public function update(Request $request, $id)
    {
        $discount = BulkDiscount::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'scope' => 'required|in:all,category,brand,products',
            'category_ids' => 'nullable|array|required_if:scope,category',
            'category_ids.*' => 'exists:categories,id',
            'product_ids' => 'nullable|array|required_if:scope,products',
            'product_ids.*' => 'exists:products,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'active' => 'boolean',
        ]);

        // Build scope_meta
        $scopeMeta = [];
        if ($request->scope === 'category' && $request->filled('category_ids')) {
            $scopeMeta['category_ids'] = $request->category_ids;
        } elseif ($request->scope === 'products' && $request->filled('product_ids')) {
            $scopeMeta['product_ids'] = $request->product_ids;
        } elseif ($request->scope === 'brand' && $request->filled('brand_ids')) {
            $scopeMeta['brand_ids'] = $request->brand_ids;
        }

        $validated['scope_meta'] = !empty($scopeMeta) ? $scopeMeta : null;
        $validated['starts_at'] = $request->starts_at ? Carbon::parse($request->starts_at) : null;
        $validated['ends_at'] = $request->ends_at ? Carbon::parse($request->ends_at) : null;
        $validated['active'] = $request->has('active') ? 1 : 0;

        $discount->update($validated);

        // Clear previous applications (scope might have changed), then reapply
        $this->removeDiscountFromProducts($discount, true);
        // Reapply discount to products without overriding manual discounts
        $this->applyDiscountToProducts($discount, false);

        return redirect()->route('admin.bulk-discounts.index')
            ->with('success', 'Bulk discount updated successfully!');
    }

    /**
     * Toggle discount status
     */
    public function toggleStatus($id)
    {
        $discount = BulkDiscount::findOrFail($id);
        $discount->active = !$discount->active;
        $discount->save();

        // Reapply if activating; clear all product pricing if deactivating
        if ($discount->active) {
            $this->applyDiscountToProducts($discount, false);
        } else {
            $this->removeDiscountFromProducts($discount, true);
        }

        return response()->json([
            'success' => true,
            'active' => $discount->active,
            'message' => $discount->active ? 'Discount enabled' : 'Discount disabled'
        ]);
    }

    /**
     * Delete a bulk discount
     */
    public function destroy($id)
    {
        $discount = BulkDiscount::findOrFail($id);
        
        // Remove discount from products before deleting
        $this->removeDiscountFromProducts($discount, true);
        
        $discount->delete();

        return redirect()->route('admin.bulk-discounts.index')
            ->with('success', 'Bulk discount deleted successfully!');
    }

    /**
     * Apply discount to products based on scope
     */
    private function applyDiscountToProducts(BulkDiscount $discount, bool $override = false)
    {
        $products = $this->getProductsByScope($discount);
        \Log::info('Applying bulk discount', [
            'discount_id' => $discount->id,
            'override' => $override,
            'product_count' => $products->count(),
            'scope' => $discount->scope
        ]);

        foreach ($products as $product) {
            if (!$override && $product->discountprice !== null && $product->bulk_discount_id === null) {
                \Log::info('Skipping product - manual discount retained', ['product_id' => $product->id]);
                continue;
            }

            $originalPrice = $product->price;
            if ($discount->discount_type === 'percentage') {
                $discountAmount = $originalPrice * ($discount->discount_value / 100);
                $newPrice = $originalPrice - $discountAmount;
            } else {
                $newPrice = max(0, $originalPrice - $discount->discount_value);
            }

            $product->discountprice = $newPrice;
            $product->discount = $discount->discount_type === 'percentage'
                ? $discount->discount_value
                : (($originalPrice - $newPrice) / $originalPrice) * 100;
            $product->bulk_discount_id = $discount->id;
            $product->save();
            \Log::info('Bulk discount applied to product', [
                'product_id' => $product->id,
                'new_price' => $newPrice,
                'discount_percent' => $product->discount,
                'override' => $override
            ]);
        }
    }

    /**
     * Remove discount from products
     */
    private function removeDiscountFromProducts(BulkDiscount $discount, bool $removeAll = false)
    {
        // If $removeAll, clear every product tagged with this bulk discount id
        if ($removeAll) {
            $products = Product::where('bulk_discount_id', $discount->id)->get();
        } else {
            // Only clear discounts that were applied by this bulk discount within current scope
            $products = $this->getProductsByScope($discount)->filter(function($p) use ($discount) {
                return $p->bulk_discount_id === $discount->id;
            });
        }

        foreach ($products as $product) {
            $product->discountprice = null;
            $product->discount = null;
            $product->bulk_discount_id = null;
            $product->save();
        }
    }

    /**
     * Get products based on discount scope
     */
    private function getProductsByScope(BulkDiscount $discount)
    {
        switch ($discount->scope) {
            case 'all':
                return Product::all();
            
            case 'category':
                if ($discount->scope_meta && isset($discount->scope_meta['category_ids'])) {
                    return Product::whereHas('categories', function($q) use ($discount) {
                        $q->whereIn('categories.id', $discount->scope_meta['category_ids']);
                    })->get();
                }
                return collect();
            
            case 'products':
                if ($discount->scope_meta && isset($discount->scope_meta['product_ids'])) {
                    return Product::whereIn('id', $discount->scope_meta['product_ids'])->get();
                }
                return collect();
            
            case 'brand':
                // If you have brand functionality
                if ($discount->scope_meta && isset($discount->scope_meta['brand_ids'])) {
                    // return Product::whereIn('brand_id', $discount->scope_meta['brand_ids'])->get();
                }
                return collect();
            
            default:
                return collect();
        }
    }
}

