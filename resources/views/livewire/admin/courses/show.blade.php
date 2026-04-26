<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.courses.index') }}" wire:navigate>
                    Courses
                </a>
                <span class="text-sm text-[rgba(30,41,59,0.35)]">/</span>
                <span class="text-sm text-[rgba(30,41,59,0.6)] truncate">{{ $course->slug }}</span>
            </div>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">{{ $course->title }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                {{ $course->excerpt ?: 'No excerpt provided.' }}
            </p>
        </div>

        <div class="flex gap-2 shrink-0">
            <flux:button variant="ghost" href="{{ route('admin.courses.edit', $course) }}" wire:navigate>
                Edit
            </flux:button>
            <flux:button variant="primary" wire:click="openCreateLesson">
                Add lesson
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Status</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ ucfirst($course->status?->value ?? (string) $course->status) }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Lessons</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $course->lessons->count() }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Price</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $course->currency }} {{ number_format((float) $course->price_amount, 2) }}</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Duration</div>
            <div class="mt-2 font-semibold text-[var(--color-smoke)]">{{ $course->duration_days }} days</div>
        </div>
        <div class="glass-card p-5 glass-soft-shadow">
            <div class="text-xs text-[rgba(30,41,59,0.6)]">Free Trial</div>
            <div class="mt-2 font-semibold {{ $course->has_free_trial ? 'text-green-600' : 'text-[rgba(30,41,59,0.4)]' }}">
                @if($course->has_free_trial)
                    🎁 {{ $course->free_trial_days }} days
                @else
                    Disabled
                @endif
            </div>
        </div>
    </div>

    <div class="glass-card p-6 glass-soft-shadow">
        <div class="flex items-center justify-between gap-3 mb-4">
            <h2 class="text-lg font-semibold text-[var(--color-smoke)]">Lessons</h2>
            <div class="text-sm text-[rgba(30,41,59,0.6)]">{{ $course->lessons->count() }} total</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs text-[rgba(30,41,59,0.6)] border-b border-[rgba(30,41,59,0.1)]">
                        <th class="pb-2">Order</th>
                        <th class="pb-2">Lesson</th>
                        <th class="pb-2">Type</th>
                        <th class="pb-2">Media</th>
                        <th class="pb-2">Status</th>
                        <th class="pb-2">Duration</th>
                        <th class="pb-2"></th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($course->lessons->sortBy('sort_order') as $lesson)
                        <tr class="border-b border-[rgba(30,41,59,0.05)]">
                            <td class="py-3 pr-3 text-[rgba(30,41,59,0.7)]">{{ $lesson->sort_order }}</td>
                            <td class="py-3 pr-3">
                                <div class="font-medium text-[var(--color-smoke)]">{{ $lesson->title }}</div>
                                <div class="text-xs text-[rgba(30,41,59,0.55)]">{{ $lesson->slug }}</div>
                            </td>
                            <td class="py-3 pr-3 text-[rgba(30,41,59,0.7)]">{{ strtoupper($lesson->content_type?->value ?? (string) $lesson->content_type) }}</td>
                            <td class="py-3 pr-3">
                                @if($lesson->video_provider === 'local')
                                    <span class="pill pill-green">Upload</span>
                                @elseif($lesson->video_provider === 'url' || $lesson->resource_url)
                                    <span class="pill pill-blue">URL</span>
                                @elseif($lesson->video_asset)
                                    <span class="pill pill-gray">{{ strtoupper($lesson->video_provider ?? 'Asset') }}</span>
                                @else
                                    <span class="text-xs text-[rgba(30,41,59,0.45)]">Empty</span>
                                @endif
                            </td>
                            <td class="py-3 pr-3">
                                @php($status = $lesson->status?->value ?? (string) $lesson->status)
                                <span class="px-2 py-1 rounded text-xs {{ $status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($status) }}
                                </span>
                                @if($lesson->is_preview)
                                    <span class="ml-2 px-2 py-1 rounded text-xs bg-indigo-100 text-indigo-700">Preview</span>
                                @endif
                            </td>
                            <td class="py-3 pr-3 text-[rgba(30,41,59,0.7)]">
                                {{ gmdate('i:s', (int) $lesson->duration_seconds) }}
                            </td>
                            <td class="py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        wire:click="openEditLesson({{ $lesson->id }})"
                                    >
                                        Edit
                                    </flux:button>
                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        wire:click="deleteLesson({{ $lesson->id }})"
                                        wire:confirm="Delete this lesson?"
                                    >
                                        Delete
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-[rgba(30,41,59,0.55)]">
                                No lessons yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <flux:modal wire:model="showCreateLessonModal">
        <flux:heading>{{ $editingLessonId ? 'Edit lesson' : 'Add lesson' }}</flux:heading>

        <div class="mt-4 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input wire:model.live="lesson_title" />
                    <flux:error name="lesson_title" />
                </flux:field>

                <flux:field>
                    <flux:label>Slug</flux:label>
                    <flux:input wire:model.blur="lesson_slug" />
                    <flux:error name="lesson_slug" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Summary</flux:label>
                <flux:textarea wire:model.blur="lesson_summary" rows="2" />
                <flux:error name="lesson_summary" />
            </flux:field>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <flux:field>
                    <flux:label>Type</flux:label>
                    <flux:select wire:model.live="lesson_content_type">
                        <option value="video">Video</option>
                        <option value="pdf">PDF</option>
                        <option value="link">Link</option>
                        <option value="text">Text</option>
                    </flux:select>
                    <flux:error name="lesson_content_type" />
                </flux:field>

                <flux:field>
                    <flux:label>Status</flux:label>
                    <flux:select wire:model.live="lesson_status">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </flux:select>
                    <flux:error name="lesson_status" />
                </flux:field>

                <flux:field>
                    <flux:label>Sort order</flux:label>
                    <flux:input type="number" wire:model.blur="lesson_sort_order" min="1" />
                    <flux:error name="lesson_sort_order" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <flux:field>
                    <flux:label>Duration (seconds)</flux:label>
                    <flux:input type="number" wire:model.blur="lesson_duration_seconds" min="0" />
                    <flux:error name="lesson_duration_seconds" />
                </flux:field>

                <flux:field>
                    <div class="flex items-center justify-between gap-3">
                        <flux:label>Preview lesson</flux:label>
                        <flux:switch wire:model.live="lesson_is_preview" />
                    </div>
                    <flux:error name="lesson_is_preview" />
                </flux:field>
            </div>

            <div class="rounded-2xl border border-[rgba(30,41,59,0.08)] bg-white/40 p-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <flux:field>
                        <flux:label>Video source</flux:label>
                        <flux:select wire:model.live="lesson_media_source">
                            <option value="upload">Upload</option>
                            <option value="url">URL</option>
                            <option value="asset">Provider asset</option>
                        </flux:select>
                        <flux:error name="lesson_media_source" />
                    </flux:field>

                    @if($lesson_media_source === 'upload')
                        <flux:field>
                            <flux:label>Video file</flux:label>
                            <flux:input type="file" wire:model="lesson_video_file" accept="video/mp4,video/webm,video/quicktime,video/x-m4v" />
                            <flux:error name="lesson_video_file" />
                            <div wire:loading wire:target="lesson_video_file" class="mt-2 text-xs text-[rgba(30,41,59,0.55)]">Uploading...</div>
                            @if($editingLessonId && $lesson_video_provider === 'local' && $lesson_video_asset)
                                <div class="mt-2 text-xs text-[rgba(30,41,59,0.55)]">Current: {{ basename($lesson_video_asset) }}</div>
                            @endif
                        </flux:field>
                    @endif
                </div>

                @if($lesson_media_source === 'url')
                    <flux:field>
                        <flux:label>Video URL</flux:label>
                        <flux:input wire:model.blur="lesson_resource_url" placeholder="https://..." />
                        <flux:error name="lesson_resource_url" />
                    </flux:field>
                @endif

                @if($lesson_media_source === 'asset')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <flux:field>
                            <flux:label>Provider</flux:label>
                            <flux:select wire:model.live="lesson_video_provider">
                                <option value="">Choose</option>
                                <option value="bunny">Bunny.net</option>
                                <option value="cloudflare-stream">Cloudflare</option>
                                <option value="vimeo">Vimeo</option>
                                <option value="s3">S3</option>
                            </flux:select>
                            <flux:error name="lesson_video_provider" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Asset ID</flux:label>
                            <flux:input wire:model.blur="lesson_video_asset" placeholder="Video ID / object key" />
                            <flux:error name="lesson_video_asset" />
                        </flux:field>
                    </div>
                @endif
            </div>

            @if($lesson_content_type !== 'video')
                <flux:field>
                    <flux:label>Resource URL</flux:label>
                    <flux:input wire:model.blur="lesson_resource_url" placeholder="https://..." />
                    <flux:error name="lesson_resource_url" />
                </flux:field>
            @endif

            <flux:field>
                <flux:label>Published at</flux:label>
                <flux:input type="datetime-local" wire:model.blur="lesson_published_at" />
                <flux:error name="lesson_published_at" />
            </flux:field>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <flux:button variant="ghost" wire:click="$set('showCreateLessonModal', false)">
                Cancel
            </flux:button>
            <flux:button variant="primary" wire:click="saveLesson" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ $editingLessonId ? 'Save' : 'Add' }}</span>
                <span wire:loading>Saving...</span>
            </flux:button>
        </div>
    </flux:modal>
</div>
