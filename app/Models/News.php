<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'category_id',
        'author_id',
        'approved_by',
        'status',
        'views_count',
        'rejection_note',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Auto-generate slug from title on creation.
     */
    protected static function booted(): void
    {
        static::creating(function (News $news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title) . '-' . Str::random(5);
            }
        });
    }

    // --- Relationships ---

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // --- Scopes ---

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeByCategory($query, string $slug)
    {
        return $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }

    // --- Helpers ---

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'submitted' => 'yellow',
            'approved' => 'blue',
            'published' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'draft' => 'Draf',
            'submitted' => 'Diajukan',
            'approved' => 'Disetujui',
            'published' => 'Dipublikasi',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }
}
