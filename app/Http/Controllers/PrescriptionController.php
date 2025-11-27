<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\LensesPrescription;
use Illuminate\Support\Facades\Auth;
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
class PrescriptionController extends BaseFrontendController
{
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('frontend.prescription', compact('product'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'lensType' => 'required|string',
                'lensFeature' => 'nullable|string',
                'lensOption' => 'nullable|string',
                'lensPrice' => 'required|numeric',
                'totalPrice' => 'required|numeric',
                'frame.id' => 'required',
                'image' => 'nullable|string', // Base64 encoded image
            ]);

            // Determine if user is authenticated or using session
            $userId = auth()->check() ? auth()->id() : null;
            $sessionId = auth()->check() ? null : session()->getId();

            // Handle prescription image if uploaded
            $prescriptionImage = null;
            if ($request->imageUploaded && $request->image) {
                // Create prescription directory if it doesn't exist
                $uploadPath = public_path('prescription');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Decode base64 image
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
                $imageName = time() . '_' . uniqid() . '.png';
                $imagePath = $uploadPath . '/' . $imageName;

                // Save image to public/prescription folder
                file_put_contents($imagePath, $imageData);
                $prescriptionImage = 'prescription/' . $imageName;
            }

            // Create prescription record
            $prescription = Prescription::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $request->frame['id'],
                'lens_type' => $request->lensType,
                'lens_feature' => $request->lensFeature,
                'lens_option' => $request->lensOption,
                'lens_price' => $request->lensPrice,
                'total_price' => $request->totalPrice,
                'prescription_type' => $request->prescriptionType,
                'prescription_data' => json_encode($request->prescription),
                'image_uploaded' => $request->imageUploaded,
                'prescription_image' => $prescriptionImage,
            ]);

            // Add to session for checkout
            session()->put('prescription_id', $prescription->id);

            return response()->json([
                'success' => true,
                'message' => 'Prescription saved successfully',
                'prescription_id' => $prescription->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving prescription: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getProductData($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->discountprice ?: $product->price,
            'main_image' => $product->main_image,
            'description' => $product->description
        ]);
    }


    public function lensesPrescription($productId)
    {
        $product = Product::findOrFail($productId);
        return view('frontend.lensesPrescription', compact('product'));
    }


    public function lensesPrescriptionStore(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'sph_right' => 'nullable|string',
            'sph_left' => 'nullable|string',
            'sph' => 'nullable|string',
            'cyl' => 'nullable|string',
            'axis' => 'nullable|string',
            'quantity' => 'nullable|string',
            'total_price' => 'required|numeric'
        ]);

        $prescription = new LensesPrescription($validated);

        if (Auth::check()) {
            $prescription->user_id = Auth::id();
        } else {
            $prescription->session_id = session()->getId();
        }

        $prescription->save();

        // Store prescription ID in session
        session()->put('lenses_prescription_id', $prescription->id);

        return response()->json([
            'success' => true,
            'lenses_prescription_id' => $prescription->id, // This is the crucial addition
            'message' => 'Prescription added to cart successfully'
        ]);
    }
}
