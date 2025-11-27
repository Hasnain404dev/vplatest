<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\PaymentMethod;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['order']);

        if ($request->has('method') && $request->method !== '') {
            $query->where('method', $request->method);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhereHas('order', function ($oq) use ($search) {
                      $oq->where('order_number', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->latest()->paginate(20)->withQueryString();

        return view('backend.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['order']);
        return view('backend.payments.show', compact('payment'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $payment->status = $validated['status'];
        $payment->admin_notes = $validated['admin_notes'] ?? null;
        $payment->verified_at = $validated['status'] === 'verified' ? now() : null;
        $payment->save();

        return redirect()->back()->with('success', 'Payment status updated successfully');
    }
}


