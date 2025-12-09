<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Wishlist;
use App\Models\Prescription;
use App\Models\Cart;
use App\Models\LensesPrescription;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class BaseFrontendController extends Controller
{
    public function __construct()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        View::share('categories', $categories);
    }
}
class CartController extends BaseFrontendController
{
    /**
     * Get the current cart identifier (user_id or session_id)
     */
    private function getCartIdentifier()
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id(), 'session_id' => null];
        } else {
            return ['user_id' => null, 'session_id' => session()->getId()];
        }
    }

    public function wishList()
    {
        if (auth()->check()) {
            // For logged-in users, get wishlist items from database
            $wishlistItems = Wishlist::where('user_id', auth()->id())
                ->with('product.categories')
                ->get();
        } else {
            // For guests, get wishlist items from session
            $sessionId = session()->getId();
            $wishlistItems = Wishlist::where('session_id', $sessionId)
                ->with('product.categories')
                ->get();
        }

        return view('frontend.wishList', compact('wishlistItems'));
    }

    public function addToWishList(Product $product, Request $request)
    {
        if (auth()->check()) {
            // For logged-in users
            $userId = auth()->id();

            // Check if product already in wishlist
            $exists = Wishlist::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->exists();

            if (!$exists) {
                Wishlist::create([
                    'user_id' => $userId,
                    'product_id' => $product->id
                ]);
            }
        } else {
            // For guests
            $sessionId = session()->getId();

            // Check if product already in wishlist
            $exists = Wishlist::where('session_id', $sessionId)
                ->where('product_id', $product->id)
                ->exists();

            if (!$exists) {
                Wishlist::create([
                    'session_id' => $sessionId,
                    'product_id' => $product->id
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist'
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist');
    }

    public function removeFromWishList(Wishlist $wishlist)
    {
        // Check if the wishlist item belongs to the current user or session
        if (auth()->check()) {
            if ($wishlist->user_id != auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized action');
            }
        } else {
            if ($wishlist->session_id != session()->getId()) {
                return redirect()->back()->with('error', 'Unauthorized action');
            }
        }

        $wishlist->delete();

        return redirect()->back()->with('success', 'Product removed from wishlist');
    }

    public function getWishlistCount()
    {
        if (auth()->check()) {
            $count = Wishlist::where('user_id', auth()->id())->count();
        } else {
            $count = Wishlist::where('session_id', session()->getId())->count();
        }

        return response()->json(['count' => $count]);
    }
    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        try {
            $productId = $request->product_id;
            $quantity = $request->quantity ?? 1;
            $colorName = $request->color_name ?? null; // Get the selected color
            $product = Product::findOrFail($productId);
            $identifier = $this->getCartIdentifier();

            // Determine the price to use (discount price or regular price)
            $price = $product->discountprice ? $product->discountprice : $product->price;

            // Check stock availability
            if ($product->stock < $quantity) {
                return back()->with('error', 'Only ' . $product->stock . ' items available in stock');
            }

            // Check if product with same color already in cart
            $cartItem = Cart::where('product_id', $productId)
                ->where(function ($query) use ($colorName) {
                    if ($colorName) {
                        $query->where('color_name', $colorName);
                    } else {
                        $query->whereNull('color_name');
                    }
                })
                ->where(function ($query) use ($identifier) {
                    if ($identifier['user_id']) {
                        $query->where('user_id', $identifier['user_id']);
                    } else {
                        $query->where('session_id', $identifier['session_id']);
                    }
                })
                ->first();

            if ($cartItem) {
                // Update quantity if same product with same color exists
                $cartItem->quantity += $quantity;
                $cartItem->total_price = $price * $cartItem->quantity;
                $cartItem->save();
            } else {
                // Create new cart item with color information
                Cart::create([
                    'user_id' => $identifier['user_id'],
                    'session_id' => $identifier['session_id'],
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $price * $quantity,
                    'color_name' => $colorName // Store the color name
                ]);
            }

            return redirect()->route('frontend.cart')->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            \Log::error('Error adding to cart: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error adding product to cart: ' . $e->getMessage());
        }
    }
    /**
     * View cart
     */
    public function viewCart()
    {
        $identifier = $this->getCartIdentifier();

        // Get cart items from database with product relationship
        $cartItems = Cart::where(function ($query) use ($identifier) {
            if ($identifier['user_id']) {
                $query->where('user_id', $identifier['user_id']);
            } else {
                $query->where('session_id', $identifier['session_id']);
            }
        })->with('product')->get();

        // Format cart items for the view
        $cart = [];
        foreach ($cartItems as $item) {
            // Determine the price to use (discount price or regular price)
            $price = $item->product->discountprice ? $item->product->discountprice : $item->product->price;

            $cart[] = [
                'id' => $item->product->id,
                'cart_id' => $item->id,
                'name' => $item->product->name,
                'regular_price' => $item->product->price,
                'discount_price' => $item->product->discountprice,
                'price' => $price, // The actual price used for calculations
                'quantity' => $item->quantity,
                'image' => $item->product->main_image, // Just use main image
                'color_name' => $item->color_name, // Include color name
                'total' => $price * $item->quantity
            ];
        }

        return view('frontend.cart', compact('cart'));
    }

    // Add this helper method to your controller
    private function getProductImage($product, $colorName)
    {
        if ($colorName) {
            // Find the color image if color is selected
            $color = $product->colors->where('color_name', $colorName)->first();
            if ($color && $color->image) {
                return asset('uploads/products/colors/' . $color->image);
            }
        }
        // Default to main product image
        return asset('uploads/products/' . $product->main_image);
    }

    /**
     * Remove item from cart (using session)
     */
    public function removeFromCart(Request $request)
    {
        $key = $request->key;
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateCartItem(Request $request)
    {
        try {
            $cartItemId = $request->id;
            $action = $request->action;
            $identifier = $this->getCartIdentifier();

            // Find the cart item
            $cartItem = Cart::where('id', $cartItemId)
                ->where(function ($query) use ($identifier) {
                    if ($identifier['user_id']) {
                        $query->where('user_id', $identifier['user_id']);
                    } else {
                        $query->where('session_id', $identifier['session_id']);
                    }
                })
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            // Update quantity
            if ($action === 'increase') {
                $cartItem->quantity += 1;
            } else if ($action === 'decrease') {
                if ($cartItem->quantity > 1) {
                    $cartItem->quantity -= 1;
                } else {
                    // Delete if quantity would be 0
                    $cartItem->delete();
                    return response()->json([
                        'success' => true,
                        'message' => 'Item removed from cart',
                        'cart_count' => $this->getCartCount()
                    ]);
                }
            }

            // Determine the price to use (discount price or regular price)
            $price = $cartItem->product->discountprice ? $cartItem->product->discountprice : $cartItem->product->price;

            // Update total price
            $cartItem->total_price = $price * $cartItem->quantity;
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'cart_count' => $this->getCartCount()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating cart item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function moveToCart(Wishlist $wishlistItem)
    {
        // Add to cart
        $product = $wishlistItem->product;
        $price = $product->discountprice ?: $product->price;

        $identifier = $this->getCartIdentifier();

        // Check if already in cart
        $cartItem = Cart::where('product_id', $product->id)
            ->where(function ($query) use ($identifier) {
                if ($identifier['user_id']) {
                    $query->where('user_id', $identifier['user_id']);
                } else {
                    $query->where('session_id', $identifier['session_id']);
                }
            })
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->total_price = $price * $cartItem->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $identifier['user_id'],
                'session_id' => $identifier['session_id'],
                'product_id' => $product->id,
                'quantity' => 1,
                'total_price' => $price
            ]);
        }

        // Remove from wishlist
        $wishlistItem->delete();

        return redirect()->route('frontend.cart')->with('success', 'Product moved to cart');
    }
    /**
     * Get cart count
     */
    private function getCartCount()
    {
        $identifier = $this->getCartIdentifier();

        return Cart::where(function ($query) use ($identifier) {
            if ($identifier['user_id']) {
                $query->where('user_id', $identifier['user_id']);
            } else {
                $query->where('session_id', $identifier['session_id']);
            }
        })
            ->count();
    }

    /**
     * Merge guest cart with user cart after login
     */
    public function mergeCart()
    {
        if (Auth::check()) {
            $sessionId = session()->getId();
            $userId = Auth::id();

            // Get guest cart items
            $guestCartItems = Cart::where('session_id', $sessionId)->get();

            foreach ($guestCartItems as $guestItem) {
                // Check if same product exists in user cart
                $userItem = Cart::where('user_id', $userId)
                    ->where('product_id', $guestItem->product_id)
                    ->first();

                if ($userItem) {
                    // Update quantity if exists
                    $userItem->quantity += $guestItem->quantity;
                    $userItem->total_price = $userItem->product->price * $userItem->quantity;
                    $userItem->save();

                    // Delete guest item
                    $guestItem->delete();
                } else {
                    // Transfer ownership to user
                    $guestItem->user_id = $userId;
                    $guestItem->session_id = null;
                    $guestItem->save();
                }
            }
        }
    }

    /**
     * Remove a specific cart item
     */
    public function removeCartItem(Request $request)
    {
        try {
            $cartItemId = $request->id;
            $identifier = $this->getCartIdentifier();

            // Find the cart item
            $cartItem = Cart::where('id', $cartItemId)
                ->where(function ($query) use ($identifier) {
                    if ($identifier['user_id']) {
                        $query->where('user_id', $identifier['user_id']);
                    } else {
                        $query->where('session_id', $identifier['session_id']);
                    }
                })
                ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            // Delete the cart item
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $this->getCartCount()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error removing cart item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error removing item from cart: ' . $e->getMessage()
            ], 500);
        }
    }


    public function checkout()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItems = Cart::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->with('product')->get();

        // Normal prescription
        $prescriptionId = request('prescription_id') ?? session('prescription_id');
        $prescription = null;
        if ($prescriptionId) {
            $prescription = \App\Models\Prescription::with('product')->find($prescriptionId);
            session()->put('prescription_id', $prescriptionId);
        }

        $lensesPrescriptionId = request('lenses_prescription_id') ?? session('lenses_prescription_id');
        $lensesPrescription = null;
        if ($lensesPrescriptionId) {
            $lensesPrescription = \App\Models\LensesPrescription::with('product')->find($lensesPrescriptionId);
            session()->put('lenses_prescription_id', $lensesPrescriptionId);
        }

        // If coming directly from prescription with no cart items, still allow checkout
        if ($cartItems->isEmpty() && !$prescription && !$lensesPrescription) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty');
        }

        // Get active sale coupons (only those marked to show as sale cards)
        $saleCoupons = \App\Models\Coupon::where('status', 1)
            ->where('show_sale_card', 1)
            ->whereNotNull('title')
            ->where(function($q) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')->orWhereRaw('usage_count < usage_limit');
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.checkout', compact('cartItems', 'prescription', 'lensesPrescription', 'saleCoupons'));
    }
}
