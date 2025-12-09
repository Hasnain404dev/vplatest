<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\CouponCustomer;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons
     */
    public function index(Request $request)
    {
        $query = Coupon::with(['category', 'product', 'assignedUser'])->latest();

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('status', 1)
                      ->where(function($q) {
                          $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                      })
                      ->where(function($q) {
                          $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                      });
            } elseif ($request->status === 'expired') {
                $query->where(function($q) {
                    $q->where('status', 0)
                      ->orWhereNotNull('valid_until')
                      ->where('valid_until', '<', now());
                });
            } elseif ($request->status === 'disabled') {
                $query->where('status', 0);
            }
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('code', 'like', "%{$request->search}%")
                  ->orWhere('title', 'like', "%{$request->search}%");
            });
        }

        $coupons = $query->paginate(20)->withQueryString();

        // Statistics
        $stats = [
            'total' => Coupon::count(),
            'active' => Coupon::where('status', 1)
                ->where(function($q) {
                    $q->whereNull('valid_from')->orWhere('valid_from', '<=', now());
                })
                ->where(function($q) {
                    $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
                })
                ->count(),
            'expired' => Coupon::whereNotNull('valid_until')
                ->where('valid_until', '<', now())
                ->count(),
            'disabled' => Coupon::where('status', 0)->count(),
        ];

        return view('backend.coupons.index', compact('coupons', 'stats'));
    }

    /**
     * Show the form for creating a new coupon
     */
    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        // Users table has no 'role' column; underlying tinyInteger 'type' (0=user,1=admin)
        // Query must use numeric value, accessor only affects retrieval, not SQL.
        $users = User::where('type', 0)->get();
        
        return view('backend.coupons.create', compact('categories', 'products', 'users'));
    }

    /**
     * Store a newly created coupon
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail('Percentage discount cannot exceed 100%.');
                    }
                },
            ],
            'min_order_amount' => 'nullable|numeric|min:0',
            'apply_on' => 'required|in:cart,category,product,user',
            'category_id' => 'nullable|exists:categories,id|required_if:apply_on,category',
            'product_id' => 'nullable|exists:products,id|required_if:apply_on,product',
            'user_id' => 'nullable|exists:users,id',
            'valid_from' => 'nullable',
            'valid_until' => 'nullable',
            'valid_days' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== null && $value !== '') {
                        $intValue = (int)$value;
                        if ($intValue < 1 || !is_numeric($value)) {
                            $fail('Valid days must be an integer greater than or equal to 1.');
                        }
                    }
                },
            ],
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'nullable',
            'per_customer_limit' => 'nullable|integer|min:1',
            'show_sale_card' => 'nullable',
            'card_color' => 'nullable|string|max:50',
            'card_gradient_from' => 'nullable|string|max:50',
            'card_gradient_to' => 'nullable|string|max:50',
        ]);

        // Handle valid_days - ensure it's properly saved
        $validDaysValue = $request->input('valid_days');
        if (!empty($validDaysValue) && is_numeric($validDaysValue) && (int)$validDaysValue >= 1) {
            $validDaysInt = (int)$validDaysValue;
            if (!$request->filled('valid_until')) {
                $validated['valid_from'] = $request->filled('valid_from') ? Carbon::parse($request->valid_from) : now();
                $validated['valid_until'] = Carbon::parse($validated['valid_from'])->addDays($validDaysInt);
            } else {
                // If both are filled, use valid_until and calculate valid_days from valid_from
                $validated['valid_from'] = $request->filled('valid_from') ? Carbon::parse($request->valid_from) : now();
                $validated['valid_until'] = Carbon::parse($request->valid_until);
            }
        } else {
            $validated['valid_from'] = $request->filled('valid_from') ? Carbon::parse($request->valid_from) : null;
            $validated['valid_until'] = $request->filled('valid_until') ? Carbon::parse($request->valid_until) : null;
        }

        // Store meta data
        $meta = [];
        if ($request->filled('per_customer_limit')) {
            $meta['per_customer_limit'] = $request->per_customer_limit;
        }

        $validated['meta'] = !empty($meta) ? $meta : null;
        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['show_sale_card'] = $request->has('show_sale_card') ? 1 : 0;

        // Ensure usage_count is set
        if (!isset($validated['usage_count'])) {
            $validated['usage_count'] = 0;
        }

        // Remove fields that shouldn't be in validated array
        unset($validated['valid_days']);
        
        // Debug logging
        \Log::info('Creating coupon with data:', $validated);

        try {
            $coupon = Coupon::create($validated);
            \Log::info('Coupon created successfully with ID: ' . $coupon->id);
        } catch (\Exception $e) {
            \Log::error('Coupon creation failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Validation data: ' . json_encode($validated));
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create coupon: ' . $e->getMessage()]);
        }

        // Handle user-specific coupons
        if ($request->apply_on === 'user') {
            // Assign to logged-in users
            if ($request->filled('assigned_users')) {
                foreach ($request->assigned_users as $userId) {
                    CouponCustomer::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => $userId,
                    ]);
                }
            }
            
            // Assign to guest customers by phone + email
            $phones = $request->input('customer_phones', []);
            $emails = $request->input('customer_emails', []);
            
            foreach ($phones as $index => $phone) {
                $phone = trim($phone);
                $email = isset($emails[$index]) ? trim($emails[$index]) : null;
                
                if (!empty($phone)) {
                    // Normalize phone number (remove spaces, dashes, etc. for storage)
                    $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);
                    
                    CouponCustomer::create([
                        'coupon_id' => $coupon->id,
                        'phone_number' => $normalizedPhone,
                        'email' => $email ?: null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    /**
     * Bulk generate coupons
     */
    public function bulkGenerate(Request $request)
    {
        $validated = $request->validate([
            'prefix' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1|max:1000',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'apply_on' => 'required|in:cart,category,product,user',
            'category_id' => 'nullable|exists:categories,id|required_if:apply_on,category',
            'product_id' => 'nullable|exists:products,id|required_if:apply_on,product',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'valid_days' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== null && $value !== '') {
                        $intValue = (int)$value;
                        if ($intValue < 1 || !is_numeric($value)) {
                            $fail('Valid days must be an integer greater than or equal to 1.');
                        }
                    }
                },
            ],
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'nullable',
        ]);

        $codes = [];
        $created = 0;

        try {
            $now = now();
            $rows = [];

            DB::transaction(function () use ($validated, $request, &$codes, &$rows, $now) {
                for ($i = 0; $i < $validated['quantity']; $i++) {
                    // Generate unique code
                    $maxAttempts = 100;
                    $attempts = 0;
                    do {
                        $code = strtoupper($validated['prefix'] . Str::random(6));
                        $attempts++;
                        if ($attempts >= $maxAttempts) {
                            throw new \Exception('Failed to generate unique coupon code after ' . $maxAttempts . ' attempts');
                        }
                    } while (Coupon::where('code', $code)->exists());

                    $codes[] = $code;

                    // Dates handling
                    if ($request->filled('valid_days') && !$request->filled('valid_until')) {
                        $validFrom = $request->valid_from ? Carbon::parse($request->valid_from) : $now;
                        $validUntil = (clone $validFrom)->addDays((int)$request->valid_days);
                    } else {
                        $validFrom = $request->valid_from ? Carbon::parse($request->valid_from) : null;
                        $validUntil = $request->valid_until ? Carbon::parse($request->valid_until) : null;
                    }

                    $rows[] = [
                        'code' => $code,
                        'title' => $request->title ?? null,
                        'description' => $request->description ?? null,
                        'discount_type' => $validated['discount_type'],
                        'discount_value' => $validated['discount_value'],
                        'min_order_amount' => $validated['min_order_amount'] ?? null,
                        'apply_on' => $validated['apply_on'],
                        'category_id' => $validated['category_id'] ?? null,
                        'product_id' => $validated['product_id'] ?? null,
                        'status' => $request->has('status') ? 1 : 0,
                        'usage_count' => 0,
                        'usage_limit' => $request->filled('usage_limit') ? (int)$validated['usage_limit'] : null,
                        'valid_from' => $validFrom,
                        'valid_until' => $validUntil,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                // Perform a single bulk insert for reliability and speed
                if (!empty($rows)) {
                    Coupon::insert($rows);
                }
            });

            $created = count($rows);

            \Log::info('Bulk coupon generation completed', [
                'created' => $created,
                'total_requested' => $validated['quantity'],
                'first_codes' => array_slice($codes, 0, 5)
            ]);

            if ($created <= 0) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error' => 'No coupons were created. Please try again.']);
            }

            return redirect()->route('admin.coupons.index')
                ->with('success', "Successfully generated {$created} coupons!");
        } catch (\Exception $e) {
            \Log::error('Bulk coupon generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to generate coupons: ' . $e->getMessage()]);
        }
    }

    /**
     * Display coupon analytics
     */
    public function analytics($id)
    {
        $coupon = Coupon::with(['usages.user', 'usages'])->findOrFail($id);

        $analytics = [
            'total_uses' => $coupon->usage_count,
            'total_discount' => $coupon->usages->sum('discount_amount'),
            'total_revenue' => $coupon->usages()->whereHas('user', function($q) {
                $q->whereNotNull('id');
            })->get()->sum(function($usage) {
                // This would need order total - for now just discount
                return $usage->discount_amount;
            }),
            'unique_users' => $coupon->usages()->distinct('user_id')->count('user_id'),
            'recent_usages' => $coupon->usages()->with('user')->latest()->take(10)->get(),
        ];

        return view('backend.coupons.analytics', compact('coupon', 'analytics'));
    }

    /**
     * Show the form for editing a coupon
     */
    public function edit($id)
    {
        $coupon = Coupon::with('allowedCustomers')->findOrFail($id);
        $categories = Category::all();
        $products = Product::all();
        // Use numeric type flag instead of non-existent 'role' column.
        $users = User::where('type', 0)->get();
        $assignedUsers = $coupon->allowedCustomers->whereNotNull('user_id')->pluck('user_id')->toArray();
        
        // Calculate valid_days from valid_from and valid_until if both exist
        $validDays = null;
        if ($coupon->valid_from && $coupon->valid_until) {
            $daysDiff = $coupon->valid_from->diffInDays($coupon->valid_until);
            // Only set if it's a positive integer >= 1
            if ($daysDiff >= 1) {
                $validDays = $daysDiff;
            }
        }

        return view('backend.coupons.edit', compact('coupon', 'categories', 'products', 'users', 'assignedUsers', 'validDays'));
    }

    /**
     * Update a coupon
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $id,
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail('Percentage discount cannot exceed 100%.');
                    }
                },
            ],
            'min_order_amount' => 'nullable|numeric|min:0',
            'apply_on' => 'required|in:cart,category,product,user',
            'category_id' => 'nullable|exists:categories,id|required_if:apply_on,category',
            'product_id' => 'nullable|exists:products,id|required_if:apply_on,product',
            'user_id' => 'nullable|exists:users,id',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'valid_days' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== null && $value !== '') {
                        $intValue = (int)$value;
                        if ($intValue < 1 || !is_numeric($value)) {
                            $fail('Valid days must be an integer greater than or equal to 1.');
                        }
                    }
                },
            ],
            'usage_limit' => 'nullable|integer|min:1',
            'status' => 'boolean',
            'per_customer_limit' => 'nullable|integer|min:1',
            'show_sale_card' => 'nullable',
            'card_color' => 'nullable|string|max:50',
            'card_gradient_from' => 'nullable|string|max:50',
            'card_gradient_to' => 'nullable|string|max:50',
        ]);

        // Handle valid_days - ensure it's properly saved
        $validDaysValue = $request->input('valid_days');
        if (!empty($validDaysValue) && is_numeric($validDaysValue) && (int)$validDaysValue >= 1) {
            $validDaysInt = (int)$validDaysValue;
            if (!$request->filled('valid_until')) {
                $validated['valid_from'] = $request->filled('valid_from') ? Carbon::parse($request->valid_from) : now();
                $validated['valid_until'] = Carbon::parse($validated['valid_from'])->addDays($validDaysInt);
            } else {
                // If both are filled, use valid_until and calculate valid_days from valid_from
                $validated['valid_from'] = $request->filled('valid_from') ? Carbon::parse($request->valid_from) : now();
                $validated['valid_until'] = Carbon::parse($request->valid_until);
            }
        } else {
            $validated['valid_from'] = $request->filled('valid_from') ? Carbon::parse($request->valid_from) : null;
            $validated['valid_until'] = $request->filled('valid_until') ? Carbon::parse($request->valid_until) : null;
        }

        // Store meta data
        $meta = $coupon->meta ?? [];
        if ($request->filled('per_customer_limit')) {
            $meta['per_customer_limit'] = $request->per_customer_limit;
        } else {
            unset($meta['per_customer_limit']);
        }

        $validated['meta'] = !empty($meta) ? $meta : null;
        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['show_sale_card'] = $request->has('show_sale_card') ? 1 : 0;

        $coupon->update($validated);

        // Handle user-specific coupons
        if ($request->apply_on === 'user') {
            // Remove existing assignments
            CouponCustomer::where('coupon_id', $coupon->id)->delete();
            
            // Assign to logged-in users
            if ($request->filled('assigned_users')) {
                foreach ($request->assigned_users as $userId) {
                    CouponCustomer::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => $userId,
                    ]);
                }
            }
            
            // Assign to guest customers by phone + email
            $phones = $request->input('customer_phones', []);
            $emails = $request->input('customer_emails', []);
            
            foreach ($phones as $index => $phone) {
                $phone = trim($phone);
                $email = isset($emails[$index]) ? trim($emails[$index]) : null;
                
                if (!empty($phone)) {
                    // Normalize phone number (remove spaces, dashes, etc. for storage)
                    $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);
                    
                    CouponCustomer::create([
                        'coupon_id' => $coupon->id,
                        'phone_number' => $normalizedPhone,
                        'email' => $email ?: null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    /**
     * Toggle coupon status
     */
    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();

        return response()->json([
            'success' => true,
            'status' => $coupon->status,
            'message' => $coupon->status ? 'Coupon enabled' : 'Coupon disabled'
        ]);
    }

    /**
     * Delete a coupon
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully!');
    }

    /**
     * Validate coupon for frontend (API)
     */
    public function validateCoupon(Request $request)
    {
        try {
            $code = $request->input('code');
            
            if (!$code) {
                return response()->json([
                    'success' => false,
                    'valid' => false,
                    'message' => 'Coupon code is required'
                ], 400);
            }

            $user = auth()->user();
            $sessionId = session()->getId();

            \Log::info('Validating coupon', [
                'code' => $code,
                'user_id' => $user?->id,
                'session_id' => $sessionId
            ]);

            // Get cart items from database
            $cartItems = \App\Models\Cart::where(function($query) use ($user, $sessionId) {
                if ($user) {
                    $query->where('user_id', $user->id);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->with('product.categories')
            ->get()
            ->map(function($item) {
                if (!$item->product) {
                    return null;
                }
                return [
                    'product' => $item->product,
                    'price' => $item->total_price / $item->quantity,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                ];
            })
            ->filter()
            ->values()
            ->toArray();

            // Also check for prescription items in session
            $prescriptionId = session('prescription_id');
            if ($prescriptionId) {
                $prescription = \App\Models\Prescription::with('product.categories')->find($prescriptionId);
                if ($prescription && $prescription->product) {
                    $cartItems[] = [
                        'product' => $prescription->product,
                        'price' => $prescription->total_price,
                        'quantity' => 1,
                        'total_price' => $prescription->total_price,
                    ];
                }
            }

            $lensesPrescriptionId = session('lenses_prescription_id');
            if ($lensesPrescriptionId) {
                $lensesPrescription = \App\Models\LensesPrescription::with('product.categories')->find($lensesPrescriptionId);
                if ($lensesPrescription && $lensesPrescription->product) {
                    $cartItems[] = [
                        'product' => $lensesPrescription->product,
                        'price' => $lensesPrescription->total_price,
                        'quantity' => 1,
                        'total_price' => $lensesPrescription->total_price,
                    ];
                }
            }

            \Log::info('Cart items for coupon validation', [
                'count' => count($cartItems),
                'items' => array_map(function($item) {
                    return [
                        'product_id' => $item['product']->id ?? null,
                        'price' => $item['price'] ?? 0,
                        'quantity' => $item['quantity'] ?? 0
                    ];
                }, $cartItems)
            ]);

            if (empty($cartItems)) {
                return response()->json([
                    'success' => false,
                    'valid' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }

            // Get phone and email from session (if customer has started checkout)
            // Normalize phone number (remove spaces, dashes, etc.)
            $phone = session('checkout_phone');
            if ($phone) {
                $phone = preg_replace('/[^0-9]/', '', trim($phone));
            }
            $email = session('checkout_email');
            if ($email) {
                $email = trim(strtolower($email));
            }
            
            $couponService = new \App\Services\CouponService();
            $result = $couponService->validate($code, $cartItems, $user, $phone, $email);

            \Log::info('Coupon validation result', $result);

            // Persist applied coupon in session so frontend and subsequent requests
            // (e.g., page refresh or placeOrder) can reference the coupon.
            try {
                session(["applied_coupon" => $result['coupon'], "coupon_discount" => $result['discount_amount']]);
            } catch (\Exception $e) {
                \Log::warning('Could not write coupon to session: ' . $e->getMessage());
            }

            // Return a stable, explicit payload the frontend expects
            $response = [
                'success' => true,
                'status' => true, // backward compatibility if frontend checked 'status'
                'valid' => true,  // backward compatibility
                'message' => $result['message'] ?? 'Coupon applied successfully',
                'coupon' => $result['coupon'] ?? null,
                'discount_amount' => $result['discount_amount'] ?? 0,
                'cart_total' => $result['cart_total'] ?? 0,
                'new_total' => $result['new_total'] ?? 0,
            ];

            return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            \Log::error('Coupon validation error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'valid' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove an applied coupon from session (frontend API)
     */
    public function removeCoupon(Request $request)
    {
        try {
            session()->forget(['applied_coupon', 'coupon_discount']);
            return response()->json([
                'success' => true,
                'valid' => false,
                'message' => 'Coupon removed',
                'discount_amount' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove coupon: ' . $e->getMessage()
            ], 500);
        }
    }
}

