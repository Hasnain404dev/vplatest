<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\ContactUs;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Existing counts
        $data['products'] = Product::count();
        $data['orders'] = Order::count();
        $data['customers'] = Customer::count();
        $data['totalEarnings'] = Order::where('status', 'completed')->sum('total_amount');

        // Monthly data for chart
        $monthlyStats = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as earnings')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'completed')
            ->groupBy('month')
            ->get()
            ->pluck('earnings', 'month')
            ->toArray();

        $productStats = Product::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $customerStats = Customer::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Prepare sequential arrays (index 0-11 for Jan-Dec)
        $chartData = [
            'sales' => array_replace(array_fill(1, 12, 0), $monthlyStats),
            'products' => array_replace(array_fill(1, 12, 0), $productStats),
            'customers' => array_replace(array_fill(1, 12, 0), $customerStats)
        ];

        // Convert to simple arrays (remove month keys)
        foreach ($chartData as &$dataset) {
            $dataset = array_values($dataset);
            // Remove first element to make array 0-indexed (Jan = 0)
            array_shift($dataset);
        }

        $data['chartData'] = $chartData;

        return view('backend.index', $data);
    }
    public function customerData(Request $request)
    {
        // Start with a base query
        $query = Customer::query();

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Apply status filter if provided
        if ($request->has('status') && !empty($request->status)) {
            // Assuming you have a status field in your customers table
            // If not, you'll need to adjust this logic
            $query->where('status', $request->status);
        }

        // Determine items per page
        $perPage = 20;
        if ($request->has('show') && in_array($request->show, [20, 30, 40])) {
            $perPage = (int)$request->show;
        }

        // Get paginated results
        $customers = $query->latest()->paginate($perPage)->withQueryString();

        return view('backend.customers.customerData', compact('customers'));
    }

    public function reviews()
    {
        return view('backend.reviews');
    }

    public function customerDetail($id)
    {
        $customer = Customer::with('orders')->findOrFail($id);
        return view('backend.customers.detail', compact('customer'));
    }
    public function customerDelete($id)
    {
        $customer = Customer::findOrFail($id);

        // Check if customer has orders
        if ($customer->orders && $customer->orders->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete customer with existing orders');
        }

        $customer->delete();

        return redirect()->route('admin.customersData')->with('success', 'Customer deleted successfully');
    }

    public function customersExport()
    {
        // Simple CSV export
        $customers = Customer::all();
        $filename = 'customers-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'First Name',
                'Last Name',
                'Email',
                'Phone',
                'Address',
                'City',
                'State',
                'Zipcode',
                'Country',
                'Created At'
            ]);

            // Add customer data
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->id,
                    $customer->first_name,
                    $customer->last_name,
                    $customer->email,
                    $customer->phone,
                    $customer->address,
                    $customer->city,
                    $customer->state,
                    $customer->zipcode,
                    $customer->country,
                    $customer->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function contactList()
    {
        // Fetch all contact messages
        $contactMessages = ContactUs::orderBy('created_at', 'desc')->get();
        return view('backend.contactList', compact('contactMessages'));
    }

    public function contactDelete($id)
    {
        // Find the contact message by ID
        $contactMessage = ContactUs::findOrFail($id);

        // Delete the contact message
        $contactMessage->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contact message deleted successfully.');
    }
}
