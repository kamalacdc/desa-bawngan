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
}
