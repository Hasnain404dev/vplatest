<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\CouponCustomer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class CouponService
{
    public function validate(string $code, $cartItems, $user = null, $phone = null, $email = null)
    {
        $code = strtoupper(trim($code));
        
        // Get coupon with lock to prevent race conditions with usage_limit
        $coupon = Coupon::where('code', $code)->lockForUpdate()->first();

        if (!$coupon) {
            throw new \Exception('Invalid coupon code.');
        }

        if (!$coupon->status) {
            throw new \Exception('This coupon is disabled.');
        }

        $now = Carbon::now();

        if ($coupon->valid_from && $now->lt($coupon->valid_from)) {
            throw new \Exception('Coupon is not yet active.');
        }

        if ($coupon->valid_until && $now->gt($coupon->valid_until)) {
            throw new \Exception('Coupon has expired.');
        }

        // Refresh coupon to get latest usage_count before checking
        $coupon->refresh();
        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            throw new \Exception('Coupon usage limit has been reached.');
        }

        $cartTotal = $this->getCartTotal($cartItems);
        if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
            throw new \Exception("Minimum order amount of Rs. {$coupon->min_order_amount} is required.");
        }

        // User-specific check - can be by user_id, phone+email, or both
        if ($coupon->apply_on === 'user') {
            $allowed = false;
            
            // Check by logged-in user ID
            if ($user) {
                $allowed = CouponCustomer::where('coupon_id', $coupon->id)
                                         ->where('user_id', $user->id)
                                         ->exists();
                
                if (!$allowed && $coupon->user_id === $user->id) {
                    $allowed = true;
                }
            }
            
            // Check by phone number + email (for guest customers)
            // Normalize phone number (remove spaces, dashes, etc.)
            if (!$allowed && $phone) {
                $normalizedPhone = preg_replace('/[^0-9]/', '', trim($phone));
                
                // Get all coupon customers for this coupon
                $couponCustomers = CouponCustomer::where('coupon_id', $coupon->id)
                                                 ->whereNotNull('phone_number')
                                                 ->get();
                
                foreach ($couponCustomers as $customer) {
                    $customerPhone = preg_replace('/[^0-9]/', '', trim($customer->phone_number));
                    
                    if ($customerPhone === $normalizedPhone) {
                        // Phone matches, now check email
                        if ($email && $customer->email) {
                            // Both have email - must match
                            $normalizedEmail = trim(strtolower($email));
                            $customerEmail = trim(strtolower($customer->email));
                            
                            if ($customerEmail === $normalizedEmail) {
                                $allowed = true;
                                break;
                            }
                        } elseif (!$customer->email) {
                            // Customer assignment has no email requirement - phone match is enough
                            $allowed = true;
                            break;
                        }
                    }
                }
            }
            
            if (!$allowed) {
                throw new \Exception('This coupon is not valid for your account.');
            }
        }

        // Per-user limit (from meta)
        $perUserLimit = $coupon->meta['per_customer_limit'] ?? null;
        if ($user && $perUserLimit) {
            $usedByUser = CouponUsage::where('coupon_id', $coupon->id)
                                     ->where('user_id', $user->id)
                                     ->count();
            if ($usedByUser >= $perUserLimit) {
                throw new \Exception('You have already used this coupon.');
            }
        }

        $cartTotal = $this->getCartTotal($cartItems);
        
        // Get eligible total (items the coupon applies to) for validation
        $eligibleTotal = $this->getEligibleTotal($coupon, $cartItems);
        
        // For category/product-specific coupons, check if there are any eligible items
        if ($coupon->apply_on === 'category') {
            if ($eligibleTotal <= 0) {
                throw new \Exception('This coupon is not valid for selected products.');
            }
            // Ensure category_id is set
            if (!$coupon->category_id) {
                throw new \Exception('This coupon is not properly configured.');
            }
        }
        
        if ($coupon->apply_on === 'product') {
            if ($eligibleTotal <= 0) {
                throw new \Exception('This coupon is not valid for selected products.');
            }
            // Ensure product_id is set
            if (!$coupon->product_id) {
                throw new \Exception('This coupon is not properly configured.');
            }
        }
        
        // Calculate discount only if there are eligible items
        $discount = $this->calculateDiscount($coupon, $cartItems);
        
        // Check if discount exceeds eligible total (for category/product specific coupons)
        if ($discount > $eligibleTotal) {
            throw new \Exception('You do not qualify for this coupon.');
        }
        
        // For fixed discount: If no minimum order is set, also check against cart total
        if ($coupon->discount_type === 'fixed' && !$coupon->min_order_amount) {
            if ($coupon->discount_value > $cartTotal) {
                throw new \Exception('You do not qualify for this coupon.');
            }
        }
        
        // Also check if calculated discount exceeds cart total (safety check)
        if ($discount > $cartTotal) {
            throw new \Exception('You do not qualify for this coupon.');
        }
        
        $newTotal = max(0, $cartTotal - $discount); // Ensure total doesn't go negative
        // Always round up the final payable amount (e.g., 245.05 → 246)
        $newTotal = ceil($newTotal);

        return [
            'valid' => true,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value,
            ],
            'discount_amount' => round($discount, 2),
            'cart_total' => round($cartTotal, 2),
            'new_total' => $newTotal,
            'message' => 'Coupon applied successfully!'
        ];
    }

    public function calculateDiscount(Coupon $coupon, $cartItems)
    {
        $eligibleTotal = $this->getEligibleTotal($coupon, $cartItems);
        
        // If no eligible items, discount is 0
        if ($eligibleTotal <= 0) {
            return 0;
        }

        if ($coupon->discount_type === 'percentage') {
            // Ensure percentage doesn't exceed 100%
            $percentage = min(100, max(0, $coupon->discount_value));
            return round($eligibleTotal * ($percentage / 100), 2);
        }

        // For fixed discount, return the full discount value
        // Validation will check if it exceeds eligible/cart total
        return $coupon->discount_value;
    }

    private function getEligibleTotal(Coupon $coupon, $cartItems)
    {
        $eligibleTotal = 0;

        foreach ($cartItems as $item) {
            // Handle both array format and object format
            $product = is_array($item) ? ($item['product'] ?? null) : ($item->product ?? null);
            $price = is_array($item) ? ($item['price'] ?? $item['total_price'] ?? 0) : ($item->price ?? $item->total_price ?? 0);
            $quantity = is_array($item) ? ($item['quantity'] ?? 1) : ($item->quantity ?? 1);
            
            if (!$product) continue;

            $applies = false;

            switch ($coupon->apply_on) {
                case 'cart':
                    $applies = true;
                    break;
                case 'category':
                    // Check if product belongs to the coupon's category
                    if ($coupon->category_id) {
                        $applies = false;
                        
                        // Load categories if not already loaded
                        if (is_array($product)) {
                            // Handle array format - categories might be nested
                            $productCategories = $product['categories'] ?? [];
                            
                            if (is_array($productCategories)) {
                                // Check if any category matches
                                foreach ($productCategories as $cat) {
                                    $catId = is_array($cat) ? ($cat['id'] ?? null) : ($cat->id ?? null);
                                    if ($catId == $coupon->category_id) {
                                        $applies = true;
                                        break;
                                    }
                                }
                            }
                        } else {
                            // Handle object format
                            // Ensure categories are loaded
                            if (!$product->relationLoaded('categories')) {
                                $product->load('categories');
                            }
                            $productCategories = $product->categories ?? collect();
                            
                            // Check if product belongs to the coupon's category
                            if (is_object($productCategories)) {
                                $applies = $productCategories->contains('id', $coupon->category_id);
                            } elseif (is_array($productCategories)) {
                                foreach ($productCategories as $cat) {
                                    $catId = is_array($cat) ? ($cat['id'] ?? null) : ($cat->id ?? null);
                                    if ($catId == $coupon->category_id) {
                                        $applies = true;
                                        break;
                                    }
                                }
                            }
                        }
                    } else {
                        $applies = false;
                    }
                    break;
                case 'product':
                    $productId = is_array($product) ? ($product['id'] ?? null) : ($product->id ?? null);
                    if ($coupon->product_id && $productId == $coupon->product_id) {
                        $applies = true;
                    }
                    break;
                case 'user':
                    $applies = true;
                    break;
            }

            if ($applies) {
                $eligibleTotal += $price * $quantity;
            }
        }

        return $eligibleTotal;
    }

    public function apply(Coupon $coupon, $cartItems, $user = null, $orderId = null)
    {
        return DB::transaction(function () use ($coupon, $user, $orderId, $cartItems) {
            // Lock and refresh coupon to check usage limit again before applying
            $coupon = Coupon::lockForUpdate()->find($coupon->id);
            
            // Double-check usage limit right before applying
            if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
                throw new \Exception('Coupon usage limit has been reached.');
            }
            
            $coupon->increment('usage_count');

            $discount = $this->calculateDiscount($coupon, $cartItems);

            CouponUsage::create([
                'coupon_id' => $coupon->id,
                'user_id' => $user?->id,
                'order_id' => $orderId,
                'discount_amount' => $discount,
                'applied_on' => json_encode($cartItems)
            ]);

            return $discount;
        });
    }

    public function rollback(Coupon $coupon, $orderId)
    {
        $usage = CouponUsage::where('coupon_id', $coupon->id)
                            ->where('order_id', $orderId)
                            ->first();

        if ($usage) {
            $coupon->decrement('usage_count');
            $usage->delete();
        }
    }

    private function getCartTotal($cartItems)
    {
        return collect($cartItems)->sum(function ($item) {
            if (is_array($item)) {
                return ($item['price'] ?? $item['total_price'] ?? 0) * ($item['quantity'] ?? 1);
            } else {
                return ($item->price ?? $item->total_price ?? 0) * ($item->quantity ?? 1);
            }
        });
    }
}