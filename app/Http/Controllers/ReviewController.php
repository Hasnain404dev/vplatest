<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function index()
    {
        $reviews = Review::with('product')->latest()->paginate(10);
        return view('backend.reviews.index', compact('reviews'));
    }

    public function updateStatus(Review $review, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $review->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Review status updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Delete all associated images
        foreach ($review->images as $image) {
            $imagePath = public_path('uploads/reviews/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $image->delete();
        }

        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'review_images.*' => 'nullable|image|max:2048',
        ]);

        $reviewData = [
            'product_id' => $product->id,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => 'pending'
        ];

        // Create the review
        $review = Review::create($reviewData);

        // Create uploads/reviews directory if it doesn't exist
        $uploadPath = public_path('uploads/reviews');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Handle multiple images
        if ($request->hasFile('review_images')) {
            foreach ($request->file('review_images') as $image) {
                $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $image->move($uploadPath, $imageName);

                // Create review image record
                $review->images()->create([
                    'image' => $imageName
                ]);
            }
        }

        return redirect()->back()->with('success', 'Your review has been submitted and is pending approval.');
    }
}




