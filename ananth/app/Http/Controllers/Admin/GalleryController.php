<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.gallery.index', compact('images'));
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
