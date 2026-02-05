<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function SliderIndex()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();
        return view('backend.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('backend.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heading' => 'nullable|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'paragraph' => 'nullable|string',
            'heading_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'sub_heading_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'paragraph_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_name' => 'nullable|string|max:50',
            'button_link' => 'nullable|url',
            'button_text_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_bg_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'background_opacity' => 'nullable|numeric|min:0|max:100',
            'text_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Create slider directory if it doesn't exist
        if (!File::exists(public_path('slider'))) {
            File::makeDirectory(public_path('slider'), 0755, true);
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('slider'), $imageName);

        Slider::create([
            'image' => 'slider/' . $imageName,
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
            'paragraph' => $request->paragraph,
            'heading_color' => $request->heading_color ?: null,
            'sub_heading_color' => $request->sub_heading_color ?: null,
            'paragraph_color' => $request->paragraph_color ?: null,
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
            'button_text_color' => $request->button_text_color ?: null,
            // Prefer new bg color; fallback to legacy button_color
            'button_bg_color' => $request->button_bg_color ?: ($request->button_color ?: null),
            'background_opacity' => $request->filled('background_opacity') ? (float) $request->background_opacity / 100 : null,
            'text_color' => $request->text_color ?: null,
            'button_color' => $request->button_color ?: null,
            'order' => $request->order ?? 0,
            'is_active' => $request->is_active ?? true,
        ]);

        Cache::forget('frontend.home.guest');
        return redirect()->route('admin.sliders')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('backend.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'heading' => 'nullable|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'paragraph' => 'nullable|string',
            'heading_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'sub_heading_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'paragraph_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_name' => 'nullable|string|max:50',
            'button_link' => 'nullable|url',
            'button_text_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_bg_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'background_opacity' => 'nullable|numeric|min:0|max:100',
            'text_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_color' => 'nullable|string|max:20|regex:/^#[0-9A-Fa-f]{6}$/',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
            'paragraph' => $request->paragraph,
            'heading_color' => $request->heading_color ?: $slider->heading_color,
            'sub_heading_color' => $request->sub_heading_color ?: $slider->sub_heading_color,
            'paragraph_color' => $request->paragraph_color ?: $slider->paragraph_color,
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
            'button_text_color' => $request->button_text_color ?: $slider->button_text_color,
            'button_bg_color' => $request->button_bg_color ?: ($request->button_color ?: $slider->button_bg_color),
            'background_opacity' => $request->filled('background_opacity') ? (float) $request->background_opacity / 100 : null,
            'text_color' => $request->text_color ?: null,
            'button_color' => $request->button_color ?: null,
            'order' => $request->order ?? $slider->order,
            'is_active' => $request->is_active ?? $slider->is_active,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }

            // Store new image
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('slider'), $imageName);
            $data['image'] = 'slider/'.$imageName;
        }

        $slider->update($data);

        Cache::forget('frontend.home.guest');
        return redirect()->route('admin.sliders')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        // Delete image from public folder
        if (File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }

        $slider->delete();

        Cache::forget('frontend.home.guest');
        return redirect()->route('admin.sliders')->with('success', 'Slider deleted successfully.');
    }
}
