<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VillageProfile;
use App\Models\News;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/demografi')->assertStatus(200)->assertViewHas('history');
        $this->get('/apbdes')->assertStatus(200);
        $this->get('/berita')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function test_super_admin_can_access_admin_pages(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);

        $this->actingAs($admin)->get('/admin')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/content/slides')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/content/visi-misi')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/content/sejarah')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/content/profile')->assertStatus(200);
        $this->actingAs($admin)->get('/admin/content/sambutan')->assertStatus(200);
    }

    public function test_super_admin_can_update_sambutan_kades(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($admin)->put('/admin/content/sambutan', [
            'welcome_title' => 'Sambutan Kepala Desa Bawangan',
            'welcome_speech' => 'Selamat datang di Desa Bawangan. Salam sejahtera.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $profile = VillageProfile::current();
        $this->assertEquals('Sambutan Kepala Desa Bawangan', $profile->welcome_title);
        $this->assertEquals('Selamat datang di Desa Bawangan. Salam sejahtera.', $profile->welcome_speech);
    }

    public function test_leader_and_gallery_create_forms_have_auto_incremented_sort_order(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);

        \App\Models\Leader::create([
            'name' => 'Perangkat 1',
            'position' => 'Kasi',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        $responseLeader = $this->actingAs($admin)->get('/admin/leaders/create');
        $responseLeader->assertStatus(200);
        $responseLeader->assertViewHas('nextSortOrder', 6);

        \App\Models\Gallery::create([
            'title' => 'Kegiatan 1',
            'image' => 'galleries/sample.jpg',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $responseGallery = $this->actingAs($admin)->get('/admin/galleries/create');
        $responseGallery->assertStatus(200);
        $responseGallery->assertViewHas('nextSortOrder', 4);
    }

    public function test_user_can_access_and_update_profile_and_password(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'name' => 'Nama Lama',
            'email' => 'lama@bawangan.id',
            'jabatan' => 'Staf IT',
        ]);

        $this->actingAs($user)->get('/admin/account/profile')->assertStatus(200)->assertSee('Nama Lama');

        $response = $this->actingAs($user)->put('/admin/account/profile', [
            'name' => 'Nama Baru Administrator',
            'email' => 'baru@bawangan.id',
            'jabatan' => 'Sekretaris Baru',
        ]);

        $response->assertRedirect('/admin/account/profile');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Nama Baru Administrator', $user->name);
        $this->assertEquals('baru@bawangan.id', $user->email);
        $this->assertEquals('Sekretaris Baru', $user->jabatan);

        // Test change-password route redirects to unified profile page
        $this->actingAs($user)->get('/admin/account/change-password')->assertRedirect('/admin/account/profile#password');
    }

    public function test_approval_menu_is_only_visible_to_super_admin(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $adminStaff = User::factory()->create(['role' => 'admin']);

        $this->actingAs($superAdmin)->get('/admin')->assertSee('Approval Berita');
        $this->actingAs($adminStaff)->get('/admin')->assertDontSee('Approval Berita');
    }
}
