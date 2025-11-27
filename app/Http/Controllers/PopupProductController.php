<?php

namespace App\Http\Controllers;

use App\Models\PopupProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PopupProductController extends Controller
{
   public function getActivePopup()
{
    $activePopup = PopupProduct::where('is_active', 1)
        ->where('offer_ends_at', '>', now())
        ->latest()
        ->first();

    return $activePopup;
}
    // Admin methods
    public function index()
    {
        $popupProducts = PopupProduct::latest()->paginate(10); // Using pagination
        return view('backend.popups.index', compact('popupProducts'));
    }

    public function create()
    {
        return view('backend.popups.create');
    }

    public function edit(PopupProduct $popupProduct)
    {
        return view('backend.popups.edit', compact('popupProduct'));
    }

    // Add these methods to your existing controller

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'offer_link' => 'required|url',
            'offer_ends_at' => 'required|date',
        ]);

        try {
            // Create popups directory if not exists
            $popupsPath = public_path('popups');
            if (!File::exists($popupsPath)) {
                File::makeDirectory($popupsPath, 0755, true);
            }

            // Process and save image
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $image->getClientOriginalName());

            // Save image to public/popups
            $image->move($popupsPath, $imageName);

            PopupProduct::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'new_price' => $validated['new_price'],
                'old_price' => $validated['old_price'],
                'image_path' => 'popups/' . $imageName,
                'offer_link' => $validated['offer_link'],
                'offer_ends_at' => $validated['offer_ends_at'],
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            return redirect()->route('admin.popups')->with('success', 'Popup created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating popup: ' . $e->getMessage());
        }
    }

    public function update(Request $request, PopupProduct $popupProduct)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'offer_link' => 'required|url',
            'offer_ends_at' => 'required|date',
        ]);

        try {
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($popupProduct->image_path && file_exists(public_path($popupProduct->image_path))) {
                    unlink(public_path($popupProduct->image_path));
                }

                // Process new image
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\.]/', '', $image->getClientOriginalName());
                $image->move(public_path('popups'), $imageName);
                $validated['image_path'] = 'popups/' . $imageName;
            }

            $popupProduct->update(array_merge($validated, [
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]));

            return redirect()->route('admin.popups')->with('success', 'Popup updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating popup: ' . $e->getMessage());
        }
    }

    public function destroy(PopupProduct $popupProduct)
    {
        try {
            // Delete image if exists
            if ($popupProduct->image_path && file_exists(public_path($popupProduct->image_path))) {
                unlink(public_path($popupProduct->image_path));
            }

            $popupProduct->delete();

            return redirect()->route('admin.popups')->with('success', 'Popup deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting popup: ' . $e->getMessage());
        }
    }
}
