<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = Leader::ordered()->paginate(20);
        return view('admin.leaders.index', compact('leaders'));
    }

    public function create()
    {
        $nextSortOrder = (Leader::max('sort_order') ?? 0) + 1;
        return view('admin.leaders.form', [
            'leader' => null,
            'nextSortOrder' => $nextSortOrder,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('leaders', 'public');
        }

        $leader = Leader::create($validated);

        ActivityLog::log('leader_create', "Menambahkan data perangkat desa: \"{$leader->name}\" ({$leader->position})", $leader);

        return redirect()
            ->route('admin.leaders.index')
            ->with('success', 'Data perangkat desa berhasil ditambahkan.');
    }

    public function edit(Leader $leader)
    {
        return view('admin.leaders.form', compact('leader'));
    }

    public function update(Request $request, Leader $leader)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($leader->photo) {
                Storage::disk('public')->delete($leader->photo);
            }
            $validated['photo'] = $request->file('photo')->store('leaders', 'public');
        }

        $leader->update($validated);

        ActivityLog::log('leader_update', "Memperbarui data perangkat desa: \"{$leader->name}\"", $leader);

        return redirect()
            ->route('admin.leaders.index')
            ->with('success', 'Data perangkat desa berhasil diperbarui.');
    }

    public function destroy(Leader $leader)
    {
        $name = $leader->name;
        if ($leader->photo) {
            Storage::disk('public')->delete($leader->photo);
        }

        $leader->delete();

        ActivityLog::log('leader_delete', "Menghapus data perangkat desa: \"{$name}\"");

        return redirect()
            ->route('admin.leaders.index')
            ->with('success', 'Data perangkat desa berhasil dihapus.');
    }
}
