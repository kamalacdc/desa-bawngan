<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::ordered();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $galleries = $query->paginate(12)->withQueryString();

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        $nextSortOrder = (Gallery::max('sort_order') ?? 0) + 1;
        return view('admin.galleries.form', [
            'gallery' => null,
            'nextSortOrder' => $nextSortOrder,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'date' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery = Gallery::create($validated);

        ActivityLog::log('gallery_create', "Menambahkan foto kegiatan galeri: \"{$gallery->title}\"", $gallery);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Foto kegiatan berhasil ditambahkan ke galeri.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.form', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'date' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($validated);

        ActivityLog::log('gallery_update', "Memperbarui foto kegiatan galeri: \"{$gallery->title}\"", $gallery);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Foto kegiatan berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $title = $gallery->title;
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        ActivityLog::log('gallery_delete', "Menghapus foto kegiatan galeri: \"{$title}\"");

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Foto kegiatan berhasil dihapus dari galeri.');
    }
}
