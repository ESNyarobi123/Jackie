<?php

namespace App\Models;

use App\Enums\LiveClassProvider;
use App\Enums\LiveClassStatus;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Database\Factories\LiveClassFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

#[Fillable([
    'course_id',
    'created_by',
    'provider',
    'status',
    'title',
    'description',
    'room_name',
    'join_url',
    'scheduled_at',
    'duration_minutes',
    'settings',
])]
class LiveClass extends Model
{
    /** @use HasFactory<LiveClassFactory> */
    use HasFactory;

    /**
     * The model's default values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'provider' => LiveClassProvider::Jitsi->value,
        'status' => LiveClassStatus::Scheduled->value,
        'duration_minutes' => 60,
        'settings' => '[]',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'provider' => LiveClassProvider::class,
            'status' => LiveClassStatus::class,
            'scheduled_at' => 'datetime',
            'duration_minutes' => 'int',
            'settings' => 'array',
        ];
    }

    /**
     * Scope classes that students may see.
     */
    public function scopeVisibleToStudents(Builder $query): Builder
    {
        return $query->whereIn('status', [
            LiveClassStatus::Scheduled->value,
            LiveClassStatus::Live->value,
        ]);
    }

    /**
     * Determine when the live class ends.
     */
    public function endsAt(): CarbonInterface
    {
        return $this->scheduled_at->copy()->addMinutes($this->duration_minutes);
    }

    /**
     * Determine whether the class can be joined right now.
     */
    public function isJoinable(?DateTimeInterface $at = null): bool
    {
        if (! in_array($this->status, [LiveClassStatus::Scheduled, LiveClassStatus::Live], true)) {
            return false;
        }

        // If admin has already started the class, allow joining immediately
        if ($this->status === LiveClassStatus::Live) {
            return true;
        }

        $now = $at === null ? now() : Carbon::parse($at);
        $opensAt = $this->scheduled_at->copy()->subMinutes((int) config('services.jitsi.join_window_before_minutes', 15));
        $closesAt = $this->endsAt()->addMinutes((int) config('services.jitsi.join_window_after_minutes', 30));

        return $now->betweenIncluded($opensAt, $closesAt);
    }

    /**
     * Get the course linked to this class.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the admin that created this class.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
