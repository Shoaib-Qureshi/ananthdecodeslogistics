<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::orderBy('sort_order')->orderByDesc('id')->get();
        $site = SiteSetting::instance();

        return view('admin.gallery.index', compact('images', 'site'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'hide_gallery_page' => 'nullable|boolean',
        ]);

        $site = SiteSetting::instance();
        $site->gallery_page_visible = empty($validated['hide_gallery_page']);
        $site->save();

        return back()->with('success', 'Gallery page visibility updated.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:160',
            'category' => 'nullable|string|max:80',
            'caption' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'visible' => 'nullable|boolean',
            'image' => 'required|image|max:5120',
        ]);

        $validated['image'] = $request->file('image')->store('gallery', 'public');
        $validated['visible'] = (bool) ($validated['visible'] ?? false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        GalleryImage::create($validated);

        return back()->with('success', 'Gallery image added.');
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:160',
            'category' => 'nullable|string|max:80',
            'caption' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'visible' => 'nullable|boolean',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($galleryImage->image);
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $validated['visible'] = (bool) ($validated['visible'] ?? false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $galleryImage->update($validated);

        return back()->with('success', 'Gallery image updated.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        Storage::disk('public')->delete($galleryImage->image);
        $galleryImage->delete();

        return back()->with('success', 'Gallery image removed.');
    }
}
