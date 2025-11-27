<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Support\Str;


class ProductController extends Controller
{

    public function products(Request $request)
    {
        $query = Product::latest();

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Date filter
        if ($request->has('date_filter') && !empty($request->date_filter)) {
            $date = $request->date_filter;
            $query->whereMonth('created_at', date('m', strtotime($date)))
                ->whereYear('created_at', date('Y', strtotime($date)));
        }

        // Search by product name
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        $products = $query->paginate(10);

        return view('backend.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('backend.products.create', compact('categories'));
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'discountprice' => 'nullable|numeric|lte:price',
            'longDescription' => 'nullable|string',
            'stock' => 'nullable|string',
            'lenses_prescription_id' => 'nullable|string',
            'main_image' => 'nullable|image',
            'color_name' => 'array',
            'color_name.*' => 'nullable|string', // Changed from 'string' to 'nullable|string'
            'color_image' => 'array',
            'color_image.*' => 'required|image',
            'virtual_try_on_image' => 'nullable|image', // Added validation
            'threeD_try_on_name' => 'nullable|string',

        ]);

        // Upload main image
        $mainImageName = null;
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImage->move(public_path('uploads/products'), $mainImageName);
        }
        // Upload virtual try on image
        $virtualTryOnImageName = null;
        if ($request->hasFile('virtual_try_on_image')) {
            $virtualTryOnImage = $request->file('virtual_try_on_image');
            $virtualTryOnImageName = time() . '_' . $virtualTryOnImage->getClientOriginalName();
            $virtualTryOnImage->move(public_path('uploads/products/virtual_try_on'), $virtualTryOnImageName);
        }

        // Calculate discount
        $price = $request->price;
        $discountPrice = $request->discountprice;
        $discount = null;

        if ($price && $discountPrice && $price > 0 && $discountPrice <= $price) {
            $discount = (($price - $discountPrice) / $price) * 100;
        }

        // Generate slug
        $slug = Str::slug($request->name);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }
        // Create product
        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'longDescription' => $request->longDescription,
            'price' => $price,
            'discountprice' => $discountPrice,
            'discount' => $discount,
            'size' => $request->size,
            'color' => $request->color,
            'material' => $request->material,
            'shape' => $request->shape,
            'rim' => $request->rim,
            'status' => $request->status,
            'tags' => $request->tags,
            'stock' => $request->stock,
            'main_image' => $mainImageName,
            'lenses_prescription_id' => $request->lenses_prescription_id,
            'virtual_try_on_image' => $virtualTryOnImageName,
            'threeD_try_on_name' => $request->threeD_try_on_name,

        ]);

        // Save colors if they exist
        if ($request->has('color_image')) {
            foreach ($request->color_image as $key => $colorImage) {
                $colorImageName = time() . '_' . $colorImage->getClientOriginalName();
                $colorImage->move(public_path('uploads/products/colors'), $colorImageName);

                Color::create([
                    'color_name' => $request->color_name[$key] ?? null, // Use null if color name not provided
                    'image' => $colorImageName,
                    'product_id' => $product->id,
                ]);
            }
        }

        // Attach categories
        if ($request->has('categories')) {
            $product->categories()->attach($request->categories);
        }

        return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }

    public function productUpdate(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'discountprice' => 'nullable|numeric|lte:price',
            'main_image' => 'nullable|image',

            'existing_color_name' => 'array',
            'existing_color_name.*' => 'nullable|string',
            'existing_color_image' => 'array',
            'existing_color_image.*' => 'nullable|image',
            'new_color_name' => 'array',
            'new_color_name.*' => 'nullable|string',
            'new_color_image' => 'array',
            'new_color_image.*' => 'required_with:new_color_name.*|image',
            'virtual_try_on_image' => 'nullable|image',
            'threeD_try_on_name' => 'nullable|string',

        ]);

        // Find the product
        $product = Product::findOrFail($id);

        // Handle image uploads (main and virtual try-on)
        $mainImageName = $this->handleImageUpload(
            $request->file('main_image'),
            $product->main_image,
            'uploads/products/',
            $request->main_image_old
        );

        $virtualTryOnImageName = $this->handleImageUpload(
            $request->file('virtual_try_on_image'),
            $product->virtual_try_on_image,
            'uploads/products/virtual_try_on/',
            $request->virtual_try_on_image_old
        );

        // Calculate discount
        $discount = null;
        if ($request->price && $request->discountprice && $request->price > 0 && $request->discountprice <= $request->price) {
            $discount = (($request->price - $request->discountprice) / $request->price) * 100;
        }

        // Update slug if name changed
        $slug = $product->slug;
        if ($product->name != $request->name) {
            $slug = Str::slug($request->name);
            $count = Product::where('slug', $slug)->where('id', '!=', $product->id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
        }

        // Update product
        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'longDescription' => $request->longDescription,
            'price' => $request->price,
            'discountprice' => $request->discountprice,
            'discount' => $discount,
            'size' => $request->size,
            'color' => $request->color,
            'material' => $request->material,
            'shape' => $request->shape,
            'rim' => $request->rim,
            'status' => $request->status,
            'tags' => $request->tags,
            'lenses_prescription_id' => $request->lenses_prescription_id,
            'stock' => $request->stock,
            'main_image' => $mainImageName,
            'virtual_try_on_image' => $virtualTryOnImageName,
            'threeD_try_on_name' => $request->threeD_try_on_name,

        ]);

        // Handle color variations
        $this->handleColorVariations($request, $product);

        // Sync categories
        $product->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    protected function handleImageUpload($newImage, $currentImage, $path, $oldImage = null)
    {
        if ($newImage) {
            // Delete old image if exists
            if ($currentImage && file_exists(public_path($path . $currentImage))) {
                unlink(public_path($path . $currentImage));
            }

            $imageName = time() . '_' . $newImage->getClientOriginalName();
            $newImage->move(public_path($path), $imageName);
            return $imageName;
        }
        return $oldImage ?? $currentImage;
    }

    protected function handleColorVariations($request, $product)
    {
        // Update existing colors (name and/or image)
        if ($request->has('existing_color_name')) {
            foreach ($request->existing_color_name as $colorId => $colorName) {
                $color = Color::find($colorId);
                if ($color) {
                    $updateData = ['color_name' => $colorName];

                    // Handle image update if provided
                    if (isset($request->existing_color_image[$colorId])) {
                        // Delete old image if exists
                        if ($color->image && file_exists(public_path('uploads/products/colors/' . $color->image))) {
                            unlink(public_path('uploads/products/colors/' . $color->image));
                        }

                        $colorImage = $request->file('existing_color_image')[$colorId];
                        $colorImageName = time() . '_' . $colorImage->getClientOriginalName();
                        $colorImage->move(public_path('uploads/products/colors'), $colorImageName);
                        $updateData['image'] = $colorImageName;
                    }

                    $color->update($updateData);
                }
            }
        }

        // Handle deleted colors
        if ($request->has('deleted_color_ids')) {
            foreach ($request->deleted_color_ids as $colorId) {
                $color = Color::find($colorId);
                if ($color) {
                    // Delete associated image
                    if ($color->image && file_exists(public_path('uploads/products/colors/' . $color->image))) {
                        unlink(public_path('uploads/products/colors/' . $color->image));
                    }
                    $color->delete();
                }
            }
        }

        // Add new colors
        if ($request->has('new_color_name')) {
            foreach ($request->new_color_name as $key => $colorName) {
                if (isset($request->new_color_image[$key])) {
                    $colorImage = $request->file('new_color_image')[$key];
                    $colorImageName = time() . '_' . $colorImage->getClientOriginalName();
                    $colorImage->move(public_path('uploads/products/colors'), $colorImageName);

                    Color::create([
                        'color_name' => $colorName,
                        'image' => $colorImageName,
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        // Delete main product image
        if ($product->main_image && file_exists(public_path('uploads/products/' . $product->main_image))) {
            unlink(public_path('uploads/products/' . $product->main_image));
        }

        // Delete color variations and their images
        foreach ($product->colors as $color) {
            if ($color->image && file_exists(public_path('uploads/products/colors/' . $color->image))) {
                unlink(public_path('uploads/products/colors/' . $color->image));
            }
            $color->delete();
        }

        // Detach categories (remove relationships)
        $product->categories()->detach();

        // Delete the product
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    public static function getColorValue($colorName)
    {
        $colorMap = [
            'red' => '#ff0000',
            'black' => '#000000',
            'white' => '#ffffff',
            'matte black' => '#28282B',
            'gold' => '#FFD700',
            'silver' => '#C0C0C0',
            'transparent' => 'rgba(255, 255, 255, 0.5)',
            'mahroon' => '#800000',
            'brown' => '#964B00',
            'tortoise' => '#997950',
            'blue' => '#0000ff',
            'purple' => '#800080',
            'gray' => '#808080',
            'green' => '#008000',
            'pink' => '#FFC0CB',
            'skin' => '#E8BEAC',
            'orange' => '#FFA500',
            'yellow' => '#FFFF00',
        ];

        return $colorMap[strtolower($colorName)] ?? '#cccccc'; // default to gray if not found
    }
}
