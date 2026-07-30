<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Leader;
use App\Models\VillageProfile;
use App\Models\PopulationData;
use App\Models\BudgetData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users (Use firstOrCreate to prevent overwriting existing accounts in production)
        User::firstOrCreate(
            ['email' => env('ADMIN_DEFAULT_EMAIL', 'sekdes@bawangan.id')],
            [
                'name' => 'Sekretaris Desa',
                'password' => Hash::make(env('ADMIN_DEFAULT_PASSWORD', 'password123')),
                'role' => 'super_admin',
                'jabatan' => 'Sekretaris Desa'
            ]
        );

        User::firstOrCreate(
            ['email' => env('STAFF_DEFAULT_EMAIL', 'admin@bawangan.id')],
            [
                'name' => 'Admin Staff',
                'password' => Hash::make(env('STAFF_DEFAULT_PASSWORD', 'password123')),
                'role' => 'admin',
                'jabatan' => 'Staf IT'
            ]
        );

        // Categories
        $categories = ['Pengumuman', 'Berita Desa', 'Pembangunan', 'Kegiatan Warga'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => \Illuminate\Support\Str::slug($cat)
            ]);
        }

        // Village Profile
        VillageProfile::create([
            'vision' => 'Mewujudkan Desa Bawangan yang Mandiri, Sejahtera, dan Berbudaya',
            'mission' => "1. Meningkatkan tata kelola pemerintahan yang baik.\n2. Memberdayakan ekonomi kerakyatan berbasis potensi lokal.\n3. Melestarikan budaya dan lingkungan.",
            'history' => 'Desa Bawangan didirikan pada tahun... (sejarah lengkap desa bisa ditambahkan di sini).',
            'phone' => '081234567890',
            'email' => 'pemdes@bawangan.id',
            'address' => 'Jl. Balai Desa No. 1, Desa Bawangan, Kec. X, Kab. Y'
        ]);

        // Leaders
        Leader::create(['name' => 'Bapak Kepala Desa', 'position' => 'Kepala Desa', 'sort_order' => 1, 'is_active' => true]);
        Leader::create(['name' => 'Bapak Sekretaris', 'position' => 'Sekretaris Desa', 'sort_order' => 2, 'is_active' => true]);
        Leader::create(['name' => 'Ibu Kasi Pemerintahan', 'position' => 'Kasi Pemerintahan', 'sort_order' => 3, 'is_active' => true]);

        // Population Data
        PopulationData::create([
            'year' => date('Y'),
            'male_count' => 1250,
            'female_count' => 1310,
            'total_families' => 650
        ]);

        // Budget Data
        BudgetData::create([
            'year' => date('Y'),
            'type' => 'income',
            'category' => 'Dana Desa (DD)',
            'amount' => 1200000000,
        ]);
        BudgetData::create([
            'year' => date('Y'),
            'type' => 'income',
            'category' => 'Alokasi Dana Desa (ADD)',
            'amount' => 450000000,
        ]);
        BudgetData::create([
            'year' => date('Y'),
            'type' => 'expense',
            'category' => 'Bidang Pembangunan Desa',
            'amount' => 800000000,
        ]);
        BudgetData::create([
            'year' => date('Y'),
            'type' => 'expense',
            'category' => 'Bidang Pemberdayaan Masyarakat',
            'amount' => 300000000,
        ]);

        // Hero Slides
        HeroSlide::create([
            'title' => 'Selamat Datang di Desa Bawangan',
            'subtitle' => 'Sistem Informasi Desa',
            'description' => 'Merawat tradisi sejarah, mendorong kemandirian ekonomi lewat UMKM unggulan, dan membangun masa depan desa yang sejahtera.',
            'button_text' => 'Jelajahi Profil Desa',
            'button_url' => '#profil',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        HeroSlide::create([
            'title' => 'Potensi UMKM Desa Bawangan',
            'subtitle' => 'Ekonomi Kreatif',
            'description' => 'Tembakau, kerajinan kayu, berondong ketan, dan dupa — produk unggulan asli warga Bawangan.',
            'button_text' => 'Lihat Produk UMKM',
            'button_url' => '#umkm',
            'sort_order' => 2,
            'is_active' => true,
        ]);
        HeroSlide::create([
            'title' => 'Transparansi & Pelayanan Publik',
            'subtitle' => 'Pemerintahan Terbuka',
            'description' => 'Berkomitmen memberikan pelayanan publik yang transparan, profesional, dan mendorong kemakmuran masyarakat.',
            'button_text' => 'Baca Berita Desa',
            'button_url' => '/berita',
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}

