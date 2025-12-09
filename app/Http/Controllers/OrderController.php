<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Prescription;
use App\Models\LensesPrescription;
use App\Models\Product;
use App\Models\Payment;
use App\PaymentMethod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\AdminOrderNotification;
use App\Mail\CustomerOrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        // Start with a base query
        $query = Order::with(['items.product', 'user'])->latest();

        // Apply filters if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('items.product', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by user if provided
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range if provided
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Determine items per page
        $perPage = 20;
        if ($request->has('show') && in_array($request->show, [20, 30, 40])) {
            $perPage = (int)$request->show;
        }

        // Get paginated results with eager loading
        $orders = $query->paginate($perPage)->withQueryString();

        // Add additional data for the view
        $orderStats = [
            'total' => $orders->total(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('backend.orders.index', compact('orders', 'orderStats'));
    }

    public function orderDetail($id)
    {
        $order = Order::with([
            'items.product',
            'items.prescription', // Now correctly related
            'items.lensesPrescription', // Now correctly related
            'user'
        ])->findOrFail($id);

        return view('backend.orders.orderDetail', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Store old status to detect change
        $oldStatus = $order->status;

        // Validate the request - only allow status and admin_notes updates
        $validatedData = $request->validate([
            'status' => 'sometimes|required|in:pending,processing,completed,cancelled',
            'admin_notes' => 'sometimes|nullable|string',
        ]);

        // Only update status and admin_notes, nothing else
        if ($request->has('status')) {
            $order->status = $validatedData['status'];
        }
        if ($request->has('admin_notes')) {
            $order->admin_notes = $validatedData['admin_notes'];
        }
        $order->save();

        // Check if the status just changed to "completed"
        if ($oldStatus !== 'completed' && $order->status === 'completed') {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product) {
                    $product->stock -= $item->quantity;
                    if ($product->stock < 0) {
                        $product->stock = 0; // prevent negative stock
                    }
                    $product->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Order status updated successfully');
    }


    public function delete($id)
    {
        $order = Order::findOrFail($id);

        // Delete related order items
        $order->items()->delete();

        // Delete the order
        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully');
    }

    public function placeOrder(Request $request)
    {
        // Dynamic validation based on payment method
        $validationRules = [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'billing_address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'payment_option' => 'required|in:' . implode(',', array_column(PaymentMethod::cases(), 'value')),
        ];

        // Add conditional validation based on payment method
        if ($request->payment_option === PaymentMethod::JAZZCASH->value) {
            $validationRules['jazzcash_transaction_id'] = 'nullable|string|max:100';
            $validationRules['jazzcash_screenshot'] = 'required|file|image|max:5120';
        } elseif ($request->payment_option === PaymentMethod::MEEZAN_BANK->value) {
            $validationRules['meezan_transaction_id'] = 'nullable|string|max:100';
            $validationRules['meezan_screenshot'] = 'required|file|image|max:5120';
        }

        $validated = $request->validate($validationRules);


        return DB::transaction(function () use ($request, $validated) {
            $userId = Auth::id();
            $sessionId = session()->getId();

            // Update or create customer record
            Customer::updateOrCreate(
                ['email' => $validated['email'] ?? 'no-email@example.com'], // Default email
                [
                    'user_id' => $userId,
                    'first_name' => $validated['fname'],
                    'last_name' => $validated['lname'],
                    'phone' => $validated['phone'],
                    'company_name' => $request->cname,
                    'country' => $request->country ?? 'Pakistan',
                    'address' => $validated['billing_address'],
                    'address2' => $request->billing_address2,
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'zipcode' => $validated['zipcode'],
                ]
            );

            // Always get fresh cart items with categories loaded
            $cartItems = Cart::with('product.categories')
                ->where(function ($query) use ($userId, $sessionId) {
                    $userId ? $query->where('user_id', $userId)
                        : $query->where('session_id', $sessionId);
                })->get();

            // Get fresh prescription data with categories loaded
            $prescription = $request->session()->get('prescription_id')
                ? Prescription::with('product.categories')->find($request->session()->get('prescription_id'))
                : null;

            $lensPrescription = $request->session()->get('lenses_prescription_id')
                ? LensesPrescription::with('product.categories')->find($request->session()->get('lenses_prescription_id'))
                : null;

            if ($cartItems->isEmpty() && !$prescription && !$lensPrescription) {
                throw ValidationException::withMessages([
                    'cart' => 'Your cart is empty',
                ]);
            }

            // Calculate base total
            $baseTotal = $cartItems->sum('total_price')
                + optional($prescription)->total_price
                + optional($lensPrescription)->total_price;

            // Handle coupon if provided
            $couponCode = $request->input('coupon_code');
            $couponDiscount = 0;
            $coupon = null;
            $couponId = null;

            if ($couponCode) {
                try {
                    $couponService = new \App\Services\CouponService();
                    
                    // Prepare cart items for coupon validation
                    $cartItemsForCoupon = $cartItems->map(function($item) {
                        return [
                            'product' => $item->product,
                            'price' => $item->total_price / $item->quantity,
                            'quantity' => $item->quantity,
                            'total_price' => $item->total_price,
                        ];
                    })->toArray();

                    // Add prescription to cart items if exists
                    if ($prescription && $prescription->product) {
                        $cartItemsForCoupon[] = [
                            'product' => $prescription->product,
                            'price' => $prescription->total_price,
                            'quantity' => 1,
                            'total_price' => $prescription->total_price,
                        ];
                    }

                    // Add lens prescription to cart items if exists
                    if ($lensPrescription && $lensPrescription->product) {
                        $cartItemsForCoupon[] = [
                            'product' => $lensPrescription->product,
                            'price' => $lensPrescription->total_price,
                            'quantity' => 1,
                            'total_price' => $lensPrescription->total_price,
                        ];
                    }

                    $user = Auth::user();
                    // Get phone and email from request for guest customer validation
                    // Normalize phone number (remove spaces, dashes, etc.)
                    $phone = isset($validated['phone']) ? preg_replace('/[^0-9]/', '', trim($validated['phone'])) : null;
                    $email = isset($validated['email']) ? trim(strtolower($validated['email'])) : null;
                    $validation = $couponService->validate($couponCode, $cartItemsForCoupon, $user, $phone, $email);
                    
                    if ($validation['valid']) {
                        $coupon = \App\Models\Coupon::where('code', strtoupper(trim($couponCode)))->first();
                        if ($coupon) {
                            $couponId = $coupon->id;
                            $couponDiscount = $validation['discount_amount'];
                            
                            // Apply coupon (increment usage count)
                            $couponService->apply($coupon, $cartItemsForCoupon, $user, null);
                        }
                    }
                } catch (\Exception $e) {
                    // Coupon validation failed, continue without coupon
                    \Log::warning("Coupon validation failed for order: " . $e->getMessage());
                }
            }

            // Calculate final total and always round up (e.g., 245.05 → 246)
            $finalTotal = max(0, $baseTotal - $couponDiscount);
            $finalTotal = ceil($finalTotal);

            // Generate unique order number
            do {
                $orderNumber = 'ORD-' . strtoupper(uniqid());
            } while (Order::where('order_number', $orderNumber)->exists());

            // Create new order
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => $orderNumber,
                'session_id' => $userId ? null : $sessionId,
                'total_amount' => $finalTotal,
                'coupon_code' => $couponCode,
                'discount_amount' => $couponDiscount,
                'status' => 'pending',
                'payment_method' => $request->payment_option,
                'first_name' => $validated['fname'],
                'last_name' => $validated['lname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company_name' => $request->cname,
                'address' => $validated['billing_address'],
                'address2' => $request->billing_address2,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zipcode' => $validated['zipcode'],
                'order_notes' => $request->order_notes,
                'different_shipping' => $request->boolean('different_shipping'),
                'shipping_address' => $request->shipping_address,
                'shipping_address2' => $request->shipping_address2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zipcode' => $request->shipping_zipcode,
            ]);
            
            // Update coupon usage with order_id if coupon was applied
            if ($coupon && $order->id) {
                \App\Models\CouponUsage::where('coupon_id', $coupon->id)
                    ->whereNull('order_id')
                    ->latest()
                    ->first()
                    ?->update(['order_id' => $order->id]);
            }

            // Create new order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price ?? $item->product->discountprice ?? $item->product->price,
                    'total' => $item->total_price,
                    'color_name' => $item->color_name,
                ]);
            }

            // Create new prescription records if exists
            if ($prescription) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $prescription->product_id,
                    'quantity' => 1,
                    'price' => $prescription->total_price,
                    'total' => $prescription->total_price,
                    'prescription_id' => $prescription->id,
                ]);
                $prescription->update(['status' => 'processing']);
            }

            if ($lensPrescription) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $lensPrescription->product_id,
                    'quantity' => 1,
                    'price' => $lensPrescription->total_price,
                    'total' => $lensPrescription->total_price,
                    'lenses_prescription_id' => $lensPrescription->id,
                ]);
            }

            // If payment method involves proof, store payment record
            $method = $request->payment_option;
            
            if (in_array($method, [PaymentMethod::JAZZCASH->value, PaymentMethod::MEEZAN_BANK->value])) {
                $screenshotPath = null;
                $transactionId = null;
                
                try {
                    if ($method === PaymentMethod::JAZZCASH->value) {
                        if ($request->hasFile('jazzcash_screenshot')) {
                            $file = $request->file('jazzcash_screenshot');
                            $filename = 'payment_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path('payments'), $filename);
                            $screenshotPath = 'payments/' . $filename; // saved under public/payments
                        }
                        $transactionId = $request->jazzcash_transaction_id;
                    } elseif ($method === PaymentMethod::MEEZAN_BANK->value) {
                        if ($request->hasFile('meezan_screenshot')) {
                            $file = $request->file('meezan_screenshot');
                            $filename = 'payment_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                            $file->move(public_path('payments'), $filename);
                            $screenshotPath = 'payments/' . $filename; // saved under public/payments
                        }
                        $transactionId = $request->meezan_transaction_id;
                    }

                    $payment = Payment::create([
                        'order_id' => $order->id,
                        'method' => $method,
                        'transaction_id' => $transactionId,
                        'screenshot_path' => $screenshotPath ?: null,
                    ]);

                } catch (\Exception $e) {
                    throw $e;
                }
            }

            // Clear cart and sessions
            Cart::where('user_id', $userId)
                ->orWhere('session_id', $sessionId)
                ->delete();

            $request->session()->forget(['prescription_id', 'lenses_prescription_id']);

            // Send notification emails
            try {
                Mail::to(config('mail.admin_email'))->send(new AdminOrderNotification($order));
                Mail::to($order->email)->send(new CustomerOrderConfirmation($order));
            } catch (\Exception $e) {
                \Log::error("Order #{$order->order_number} email failed: " . $e->getMessage());
            }

            return redirect()->route('frontend.orderComplete')
                ->with('success', 'Order placed successfully!')
                ->with('order_number', $order->order_number);
        });
    }
    public function print($id)
    {
        $order = Order::with([
            'items.product',
            'items.prescription',
            'items.lensesPrescription',
            'user'
        ])->findOrFail($id);

        return view('backend.orders.print', compact('order'));
    }

}
