<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record an activity log entry.
     */
    public static function log(string $action, string $description, $subject = null): self
    {
        $user = Auth::user();

        return static::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'Sistem',
            'user_role' => $user ? $user->role : 'system',
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Get badge color based on action type.
     */
    public function actionBadgeColor(): string
    {
        if (str_contains($this->action, 'approve') || str_contains($this->action, 'publish')) {
            return 'emerald';
        }
        if (str_contains($this->action, 'reject') || str_contains($this->action, 'delete') || str_contains($this->action, 'clear')) {
            return 'rose';
        }
        if (str_contains($this->action, 'create') || str_contains($this->action, 'store') || str_contains($this->action, 'submit')) {
            return 'sky';
        }
        if (str_contains($this->action, 'update') || str_contains($this->action, 'sync')) {
            return 'indigo';
        }
        if (str_contains($this->action, 'login') || str_contains($this->action, 'logout') || str_contains($this->action, 'password')) {
            return 'amber';
        }
        return 'slate';
    }

    /**
     * Human-readable label for action type.
     */
    public function actionLabel(): string
    {
        return match ($this->action) {
            'login' => 'Login System',
            'logout' => 'Logout System',
            'password_reset' => 'Reset Password',
            'change_password' => 'Ganti Password',
            'content_slides_update' => 'Update Slides Carousel',
            'content_visimisi_update' => 'Update Visi & Misi',
            'content_sejarah_update' => 'Update Sejarah Desa',
            'content_profile_update' => 'Update Profil Desa',
            'content_update' => 'Update Konten',
            'news_create' => 'Buat Berita',
            'news_update' => 'Update Berita',
            'news_submit' => 'Pengajuan Approval',
            'news_approve' => 'Setujui Berita',
            'news_reject' => 'Tolak Berita',
            'news_delete' => 'Hapus Berita',
            'population_sync' => 'Sync Data Penduduk',
            'population_create' => 'Tambah Data Penduduk',
            'population_update' => 'Update Data Penduduk',
            'population_delete' => 'Hapus Data Penduduk',
            'budget_sync' => 'Sync Data APBDes',
            'budget_create' => 'Tambah APBDes',
            'budget_update' => 'Update APBDes',
            'budget_delete' => 'Hapus APBDes',
            'user_create' => 'Tambah Pengguna',
            'user_update' => 'Update Pengguna',
            'user_delete' => 'Hapus Pengguna',
            'leader_create' => 'Tambah Perangkat',
            'leader_update' => 'Update Perangkat',
            'leader_delete' => 'Hapus Perangkat',
            'clear_logs' => 'Bersihkan Log',
            default => str_replace('_', ' ', strtoupper($this->action)),
        };
    }
}
