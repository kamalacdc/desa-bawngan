<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Search filter (keyword in description or action or user_name)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%");
            });
        }

        // Action filter
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        // User filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $logs = $query->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.activity_logs.index', compact('logs', 'users', 'actions'));
    }

    public function clear(Request $request)
    {
        ActivityLog::truncate();

        ActivityLog::log('clear_logs', 'Super Admin menghapus seluruh riwayat log aktivitas.');

        return redirect()->route('admin.activity-logs')->with('success', 'Seluruh riwayat log aktivitas telah dibersihkan.');
    }
}
