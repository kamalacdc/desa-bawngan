<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['author', 'category'])->latest();

        // Super admin sees all, staff sees only their own
        if (Auth::user()->isStaff()) {
            $query->where('author_id', Auth::id());
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['author_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('news', 'public');
        }

        $news = News::create($validated);

        ActivityLog::log('news_create', "Membuat draf berita baru: \"{$news->title}\"", $news);

        return redirect()
            ->route('admin.news.edit', $news)
            ->with('success', 'Berita berhasil dibuat sebagai draf.');
    }

    public function edit(News $news)
    {
        // Staff can only edit own non-published articles
        if (Auth::user()->isStaff()) {
            if ($news->author_id !== Auth::id()) {
                abort(403);
            }
            if ($news->isPublished()) {
                return redirect()
                    ->route('admin.news.index')
                    ->with('error', 'Berita yang sudah dipublikasikan tidak dapat diubah kembali oleh Staf Admin.');
            }
        }

        $categories = Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        if (Auth::user()->isStaff()) {
            if ($news->author_id !== Auth::id()) {
                abort(403);
            }
            if ($news->isPublished()) {
                return redirect()
                    ->route('admin.news.index')
                    ->with('error', 'Berita yang sudah dipublikasikan tidak dapat diubah kembali oleh Staf Admin.');
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('news', 'public');
        }

        $news->update($validated);

        ActivityLog::log('news_update', "Mengubah konten berita: \"{$news->title}\"", $news);

        return redirect()
            ->route('admin.news.edit', $news)
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        $title = $news->title;

        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        ActivityLog::log('news_delete', "Super Admin menghapus berita: \"{$title}\"");

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Submit a draft article for approval.
     */
    public function submit(News $news)
    {
        if ($news->author_id !== Auth::id() && !Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        if (!in_array($news->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Berita ini tidak dapat diajukan.');
        }

        $news->update([
            'status' => 'submitted',
            'rejection_note' => null,
        ]);

        ActivityLog::log('news_submit', "Mengajukan berita \"{$news->title}\" untuk approval", $news);

        return back()->with('success', 'Berita berhasil diajukan untuk persetujuan.');
    }

    /**
     * Display the specified news article detail / preview.
     */
    public function show(News $news)
    {
        // Staff can only view own draft/submitted articles unless published
        if (Auth::user()->isStaff() && $news->author_id !== Auth::id() && $news->status !== 'published') {
            abort(403);
        }

        $news->load(['author', 'category', 'approver']);

        return view('admin.news.show', compact('news'));
    }
}
