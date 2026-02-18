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
            'image_desktop' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
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

        $desktopName = time().'_d'.'.'.$request->file('image_desktop')->extension();
        $request->file('image_desktop')->move(public_path('slider'), $desktopName);

        $mobilePath = null;
        if ($request->hasFile('image_mobile')) {
            $mobileName = time().'_m'.'.'.$request->file('image_mobile')->extension();
            $request->file('image_mobile')->move(public_path('slider'), $mobileName);
            $mobilePath = 'slider/' . $mobileName;
        }

        Slider::create([
            // Keep legacy 'image' populated for backward-compat
            'image' => 'slider/' . $desktopName,
            'image_desktop' => 'slider/' . $desktopName,
            'image_mobile' => $mobilePath,
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
            'image_desktop' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
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

        if ($request->hasFile('image_desktop')) {
            // Delete old desktop image if exists
            $old = $slider->image_desktop ?? $slider->image;
            if ($old && File::exists(public_path($old))) {
                File::delete(public_path($old));
            }
            $desktopName = time().'_d'.'.'.$request->file('image_desktop')->extension();
            $request->file('image_desktop')->move(public_path('slider'), $desktopName);
            $data['image_desktop'] = 'slider/'.$desktopName;
            // keep legacy image in sync
            $data['image'] = $data['image_desktop'];
        }

        if ($request->hasFile('image_mobile')) {
            // Delete old mobile image if exists
            if ($slider->image_mobile && File::exists(public_path($slider->image_mobile))) {
                File::delete(public_path($slider->image_mobile));
            }
            $mobileName = time().'_m'.'.'.$request->file('image_mobile')->extension();
            $request->file('image_mobile')->move(public_path('slider'), $mobileName);
            $data['image_mobile'] = 'slider/'.$mobileName;
        }

        $slider->update($data);

        Cache::forget('frontend.home.guest');
        return redirect()->route('admin.sliders')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        // Delete images from public folder
        $paths = array_filter([
            $slider->image,
            $slider->image_desktop,
            $slider->image_mobile,
        ]);
        foreach ($paths as $p) {
            if ($p && File::exists(public_path($p))) {
                File::delete(public_path($p));
            }
        }

        $slider->delete();

        Cache::forget('frontend.home.guest');
        return redirect()->route('admin.sliders')->with('success', 'Slider deleted successfully.');
    }
}
