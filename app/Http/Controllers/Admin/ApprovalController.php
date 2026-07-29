<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /**
     * List all submitted articles pending approval.
     */
    public function index()
    {
        $pendingNews = News::with(['author', 'category'])
            ->where('status', 'submitted')
            ->latest()
            ->paginate(10);

        return view('admin.approvals.index', compact('pendingNews'));
    }

    /**
     * Approve a submitted article.
     */
    public function approve(News $news)
    {
        if ($news->status !== 'submitted') {
            return back()->with('error', 'Berita ini tidak dalam status diajukan.');
        }

        $news->update([
            'status' => 'published',
            'approved_by' => Auth::id(),
            'published_at' => now(),
            'rejection_note' => null,
        ]);

        ActivityLog::log('news_approve', "Super Admin menyetujui dan mempublikasikan berita: \"{$news->title}\"", $news);

        return back()->with('success', 'Berita berhasil disetujui dan dipublikasikan.');
    }

    /**
     * Reject a submitted article with a note.
     */
    public function reject(Request $request, News $news)
    {
        $request->validate([
            'rejection_note' => 'nullable|string|max:1000',
        ]);

        if ($news->status !== 'submitted') {
            return back()->with('error', 'Berita ini tidak dalam status diajukan.');
        }

        $note = $request->rejection_note ?? 'Ditolak tanpa catatan khusus';

        $news->update([
            'status' => 'rejected',
            'rejection_note' => $note,
        ]);

        ActivityLog::log('news_reject', "Super Admin menolak berita: \"{$news->title}\" dengan catatan: \"{$note}\"", $news);

        return back()->with('success', 'Berita berhasil ditolak.');
    }
}

