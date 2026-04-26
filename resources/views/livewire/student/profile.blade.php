<?php

use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $bio = '';
    public $location = '';
    public $avatar;
    public $tempAvatar;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->bio = $user->bio ?? '';
        $this->location = $user->location ?? '';
    }

    public function saveProfile()
    {
        $user = auth()->user();
        
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:100',
        ]);

        $user->update($validated);
        
        $this->dispatch('notify', message: 'Profile updated successfully!');
    }

    public function updatedTempAvatar()
    {
        $this->validate([
            'tempAvatar' => 'image|max:1024', // 1MB Max
        ]);
        
        // In real app, store the file and update user avatar
        $this->dispatch('notify', message: 'Avatar updated!');
    }
}; ?>

<div class="space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold text-(--color-smoke)">My Profile</h1>
        <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Manage your personal information</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="md:col-span-1">
            <div class="glass-card p-6 text-center glass-elevated">
                <div class="relative inline-block mb-4">
                    <div class="w-24 h-24 rounded-full mx-auto flex items-center justify-center text-3xl font-bold text-white" 
                         style="background: linear-gradient(135deg, var(--color-terra), #F58220);">
                        @if($tempAvatar)
                            <img src="{{ $tempAvatar->temporaryUrl() }}" class="w-full h-full rounded-full object-cover">
                        @else
                            {{ auth()->user()->initials() }}
                        @endif
                    </div>
                    <label class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-white shadow-lg flex items-center justify-center cursor-pointer hover:bg-[rgba(245,130,32,0.1)] transition-colors">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        <input type="file" wire:model="tempAvatar" class="hidden" accept="image/*">
                    </label>
                </div>
                <h2 class="font-bold text-lg text-(--color-smoke)">{{ $name }}</h2>
                <p class="text-sm text-[rgba(30,41,59,0.6)]">{{ $email }}</p>
                <div class="mt-4 pt-4 border-t border-[rgba(30,41,59,0.08)]">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-xl font-bold text-(--color-terra)">{{ auth()->user()->enrollments()->active()->count() }}</div>
                            <div class="text-xs text-[rgba(30,41,59,0.5)]">Courses</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-green-500">{{ auth()->user()->enrollments()->where('progress_percentage', '>=', 100)->count() }}</div>
                            <div class="text-xs text-[rgba(30,41,59,0.5)]">Completed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="md:col-span-2">
            <div class="glass-card p-6 glass-soft-shadow">
                <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Edit Profile</h2>
                <form wire:submit="saveProfile" class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Full Name</label>
                            <input type="text" wire:model="name" 
                                   class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors">
                            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Email Address</label>
                            <input type="email" wire:model="email" 
                                   class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors">
                            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Phone Number</label>
                            <input type="tel" wire:model="phone" 
                                   class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Location</label>
                            <input type="text" wire:model="location" placeholder="City, Country"
                                   class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Bio</label>
                        <textarea wire:model="bio" rows="3" placeholder="Tell us about yourself..."
                                  class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors resize-none"></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="btn-premium">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                        <a href="{{ route('password.request') }}" class="text-sm text-[rgba(30,41,59,0.6)] hover:text-(--color-terra) transition-colors">
                            Change Password
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
