<?php

namespace App\Models;

use App\Enums\LessonContentType;
use App\Enums\LessonStatus;
use Database\Factories\LessonFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

#[Fillable([
    'course_id',
    'title',
    'slug',
    'summary',
    'content_type',
    'status',
    'video_provider',
    'video_asset',
    'resource_url',
    'duration_seconds',
    'sort_order',
    'is_preview',
    'published_at',
])]
class Lesson extends Model
{
    /** @use HasFactory<LessonFactory> */
    use HasFactory;

    /**
     * The model's default values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'content_type' => LessonContentType::Video->value,
        'status' => LessonStatus::Draft->value,
        'duration_seconds' => 0,
        'sort_order' => 1,
        'is_preview' => false,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content_type' => LessonContentType::class,
            'status' => LessonStatus::class,
            'duration_seconds' => 'int',
            'sort_order' => 'int',
            'is_preview' => 'bool',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Scope published lessons.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', LessonStatus::Published->value);
    }

    /**
     * Get the course for the lesson.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function quiz(): HasOne
    {
        return $this->hasOne(Quiz::class);
    }
}
