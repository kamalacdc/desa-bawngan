<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HeroSlide;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Show the carousel slides management page.
     */
    public function slides()
    {
        $slides = HeroSlide::ordered()->get();

        // Ensure we always have 3 slide slots
        while ($slides->count() < 3) {
            $slides->push(new HeroSlide([
                'sort_order' => $slides->count() + 1,
                'is_active' => false,
            ]));
        }

        return view('admin.content.slides', compact('slides'));
    }

    /**
     * Update the carousel slides.
     */
    public function updateSlides(Request $request)
    {
        $validated = $request->validate([
            'slides' => 'required|array|max:3',
            'slides.*.id' => 'nullable|integer|exists:hero_slides,id',
            'slides.*.title' => 'required|string|max:255',
            'slides.*.subtitle' => 'nullable|string|max:255',
            'slides.*.description' => 'nullable|string|max:500',
            'slides.*.button_text' => 'nullable|string|max:100',
            'slides.*.button_url' => 'nullable|string|max:255',
            'slides.*.is_active' => 'nullable',
            'slides.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'slides.*.remove_image' => 'nullable',
        ]);

        foreach ($validated['slides'] as $index => $slideData) {
            $slide = !empty($slideData['id'])
                ? HeroSlide::find($slideData['id'])
                : new HeroSlide();

            $slide->title = $slideData['title'];
            $slide->subtitle = $slideData['subtitle'] ?? null;
            $slide->description = $slideData['description'] ?? null;
            $slide->button_text = $slideData['button_text'] ?? null;
            $slide->button_url = $slideData['button_url'] ?? null;
            $slide->sort_order = $index + 1;
            $slide->is_active = isset($slideData['is_active']);

            // Handle image removal
            if (isset($slideData['remove_image']) && $slide->image) {
                Storage::disk('public')->delete($slide->image);
                $slide->image = null;
            }

            // Handle new image upload
            if ($request->hasFile("slides.{$index}.image")) {
                // Delete old image if exists
                if ($slide->image) {
                    Storage::disk('public')->delete($slide->image);
                }
                $slide->image = $request->file("slides.{$index}.image")
                    ->store('slides', 'public');
            }

            $slide->save();
        }

        ActivityLog::log('content_slides_update', 'Super Admin memperbarui konfigurasi slide carousel beranda.');

        return back()->with('success', 'Slide carousel berhasil diperbarui.');
    }

    /**
     * Show the visi misi management page.
     */
    public function visiMisi()
    {
        $profile = VillageProfile::current();
        return view('admin.content.visi-misi', compact('profile'));
    }

    /**
     * Update visi & misi content.
     */
    public function updateVisiMisi(Request $request)
    {
        $validated = $request->validate([
            'vision' => 'required|string|max:1000',
            'mission' => 'required|string|max:2000',
        ]);

        $profile = VillageProfile::current();
        $profile->update($validated);

        ActivityLog::log('content_visimisi_update', 'Super Admin memperbarui teks Visi & Misi Desa.', $profile);

        return back()->with('success', 'Visi & Misi berhasil diperbarui.');
    }

    /**
     * Show the sejarah management page.
     */
    public function sejarah()
    {
        $profile = VillageProfile::current();
        return view('admin.content.sejarah', compact('profile'));
    }

    /**
     * Update sejarah content.
     */
    public function updateSejarah(Request $request)
    {
        $validated = $request->validate([
            'history' => 'required|string|max:5000',
        ]);

        $profile = VillageProfile::current();
        $profile->update($validated);

        ActivityLog::log('content_sejarah_update', 'Super Admin memperbarui teks Sejarah Desa.', $profile);

        return back()->with('success', 'Sejarah Desa berhasil diperbarui.');
    }

    /**
     * Show the village profile management page.
     */
    public function profile()
    {
        $profile = VillageProfile::current();
        return view('admin.content.profile', compact('profile'));
    }

    /**
     * Update village profile content.
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        $profile = VillageProfile::current();
        $profile->update($validated);

        ActivityLog::log('content_profile_update', 'Super Admin memperbarui rincian Profil Desa.', $profile);

        return back()->with('success', 'Profil Desa berhasil diperbarui.');
    }

    /**
     * Show the sambutan kades management page.
     */
    public function sambutan()
    {
        $profile = VillageProfile::current();
        $kades = \App\Models\Leader::where('is_active', true)->orderBy('sort_order')->first();
        return view('admin.content.sambutan', compact('profile', 'kades'));
    }

    /**
     * Update sambutan kades content.
     */
    public function updateSambutan(Request $request)
    {
        $validated = $request->validate([
            'welcome_title' => 'nullable|string|max:255',
            'welcome_speech' => 'required|string|max:5000',
        ]);

        $profile = VillageProfile::current();
        $profile->update($validated);

        ActivityLog::log('content_sambutan_update', 'Super Admin memperbarui teks Sambutan Kepala Desa.', $profile);

        return back()->with('success', 'Sambutan Kepala Desa berhasil diperbarui.');
    }
}
