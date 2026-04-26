<?php

use Livewire\Component;

new class extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $videoQuality = '480p';
    public $smsReminders = true;
    public $emailNotifications = true;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '+255';
    }

    public function saveProfile()
    {
        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
        
        $this->dispatch('notify', message: 'Profile saved successfully!');
    }

    public function savePreferences()
    {
        // Save preferences to user settings
        $this->dispatch('notify', message: 'Preferences saved!');
    }
}; ?>

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-(--color-smoke)">Account Settings</h1>
        <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Manage your profile and preferences</p>
    </div>

    <!-- Profile Info -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">My Profile</h2>
        <form wire:submit="saveProfile" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Name</label>
                <input type="text" wire:model="name" class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Email</label>
                <input type="email" wire:model="email" class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1">Phone Number</label>
                <input type="tel" wire:model="phone" class="w-full px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra) transition-colors">
            </div>
            <button type="submit" class="btn-premium">Save Changes</button>
        </form>
    </div>

    <!-- Preferences -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Notifications</h2>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 rounded-lg bg-[rgba(255,255,255,0.4)]">
                <div>
                    <h4 class="font-medium text-sm text-(--color-smoke)">SMS Reminders</h4>
                    <p class="text-xs text-[rgba(30,41,59,0.5)]">Get SMS about courses and payments</p>
                </div>
                <button wire:click="$set('smsReminders', !{{ $smsReminders }})" 
                        class="w-12 h-6 rounded-full transition-colors {{ $smsReminders ? 'bg-(--color-terra)' : 'bg-[rgba(30,41,59,0.2)]' }}">
                    <span class="block w-5 h-5 rounded-full bg-white transition-transform {{ $smsReminders ? 'translate-x-6' : 'translate-x-0.5' }}"></span>
                </button>
            </div>
            <div class="flex items-center justify-between p-3 rounded-lg bg-[rgba(255,255,255,0.4)]">
                <div>
                    <h4 class="font-medium text-sm text-(--color-smoke)">Email Notifications</h4>
                    <p class="text-xs text-[rgba(30,41,59,0.5)]">Receive notifications on your email</p>
                </div>
                <button wire:click="$set('emailNotifications', !{{ $emailNotifications }})" 
                        class="w-12 h-6 rounded-full transition-colors {{ $emailNotifications ? 'bg-(--color-terra)' : 'bg-[rgba(30,41,59,0.2)]' }}">
                    <span class="block w-5 h-5 rounded-full bg-white transition-transform {{ $emailNotifications ? 'translate-x-6' : 'translate-x-0.5' }}"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Video Quality -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Video Quality</h2>
        <div class="flex items-center gap-4">
            <label class="text-sm text-[rgba(30,41,59,0.7)]">Quality:</label>
            <select wire:model="videoQuality" class="px-3 py-2 rounded-lg border border-[rgba(30,41,59,0.12)] bg-[rgba(255,255,255,0.5)] focus:outline-none focus:border-(--color-terra)">
                <option value="360p">360p (Low Data)</option>
                <option value="480p">480p (Standard)</option>
                <option value="720p">720p (HD)</option>
            </select>
        </div>
        <p class="text-xs text-[rgba(30,41,59,0.5)] mt-2">Select 360p to save your data</p>
    </div>

    <!-- Security -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Security</h2>
        <a href="{{ route('password.request') }}" class="btn-glass-outline text-sm">Change Password</a>
    </div>
</div>