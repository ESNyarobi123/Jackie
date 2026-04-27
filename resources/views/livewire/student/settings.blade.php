<div class="space-y-8">
    <style>
        @keyframes setFadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        .set-fade-up { animation: setFadeUp .4s ease-out both; }
        .set-fade-up-1 { animation-delay: .05s; }
        .set-fade-up-2 { animation-delay: .1s; }
        .set-fade-up-3 { animation-delay: .15s; }
        .set-fade-up-4 { animation-delay: .2s; }
        .set-toggle { transition: background .25s ease; }
        .set-toggle-knob { transition: transform .25s ease; }
    </style>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl" style="background: linear-gradient(135deg, #1e1a1d 0%, #2d2528 40%, #3a2f32 100%);">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 30%, rgba(245,130,32,.6) 0%, transparent 50%), radial-gradient(circle at 20% 80%, rgba(245,130,32,.3) 0%, transparent 40%);"></div>
        <div class="relative px-8 py-10 md:py-12">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0" style="background: rgba(245,130,32,.15); border: 1px solid rgba(245,130,32,.2);">
                    <svg class="w-8 h-8" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.642.78-.95 1.29-.644l2.593 1.506a.75.75 0 00.812 0l2.593-1.506c.51-.306 1.2-.002 1.29.644l.348 2.12a.75.75 0 00.565.57l2.048.47a.75.75 0 01.537.92l-.536 2.065a.75.75 0 00.12.692l1.3 1.705a.75.75 0 01-.046.958l-1.55 1.508a.75.75 0 00-.215.656l.274 2.117a.75.75 0 01-.783.837l-2.133-.135a.75.75 0 00-.634.277l-1.355 1.677a.75.75 0 01-.948.194L12 18.822l-1.914 1.033a.75.75 0 01-.948-.194l-1.355-1.677a.75.75 0 00-.634-.277l-2.133.135a.75.75 0 01-.783-.837l.274-2.117a.75.75 0 00-.215-.656l-1.55-1.508a.75.75 0 01-.046-.958l1.3-1.705a.75.75 0 00.12-.692l-.536-2.065a.75.75 0 01.537-.92l2.048-.47a.75.75 0 00.565-.57l.348-2.12z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-1 tracking-tight">Account Settings</h1>
                    <p class="text-sm text-[rgba(255,255,255,.45)]">Manage your profile and preferences</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Info -->
    <div class="rounded-2xl p-6 set-fade-up set-fade-up-1" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-5">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #f58220, rgba(245,130,32,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">My Profile</h2>
        </div>
        <form wire:submit="saveProfile" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="flex items-center gap-1.5 text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1.5">
                        <svg class="w-4 h-4 text-[rgba(30,41,59,0.4)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        Name
                    </label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(245,130,32,0.2)] transition-all" style="border: 1px solid rgba(30,41,59,.1); background: rgba(255,255,255,.5);">
                </div>
                <div>
                    <label class="flex items-center gap-1.5 text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1.5">
                        <svg class="w-4 h-4 text-[rgba(30,41,59,0.4)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.23v13.52A2.25 2.25 0 0119.5 21.976H4.5a2.25 2.25 0 01-2.25-2.25V6.23a2.25 2.25 0 012.25-2.25h15a2.25 2.25 0 012.25 2.25z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5l8.25 5.25L19.5 7.5"/></svg>
                        Email
                    </label>
                    <input type="email" wire:model="email" class="w-full px-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(245,130,32,0.2)] transition-all" style="border: 1px solid rgba(30,41,59,.1); background: rgba(255,255,255,.5);">
                </div>
            </div>
            <div class="md:max-w-md">
                <label class="flex items-center gap-1.5 text-sm font-medium text-[rgba(30,41,59,0.7)] mb-1.5">
                    <svg class="w-4 h-4 text-[rgba(30,41,59,0.4)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                    Phone Number
                </label>
                <input type="tel" wire:model="phone" class="w-full px-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[rgba(245,130,32,0.2)] transition-all" style="border: 1px solid rgba(30,41,59,.1); background: rgba(255,255,255,.5);">
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:scale-105 active:scale-95" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Notifications -->
    <div class="rounded-2xl p-6 set-fade-up set-fade-up-2" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-5">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #3b82f6, rgba(59,130,246,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">Notifications</h2>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,.08);">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-sm text-(--color-smoke)">SMS Reminders</h4>
                        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Get SMS about courses and payments</p>
                    </div>
                </div>
                <button wire:click="$set('smsReminders', !{{ $smsReminders }})"
                        class="set-toggle relative w-11 h-6 rounded-full {{ $smsReminders ? '' : '' }}"
                        style="background: {{ $smsReminders ? 'var(--color-terra)' : 'rgba(30,41,59,0.15)' }};">
                    <span class="set-toggle-knob absolute top-0.5 w-5 h-5 rounded-full bg-white shadow-sm {{ $smsReminders ? 'translate-x-5.5' : 'translate-x-0.5' }}"></span>
                </button>
            </div>
            <div class="flex items-center justify-between p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(139,92,246,.08);">
                        <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.23v13.52A2.25 2.25 0 0119.5 21.976H4.5a2.25 2.25 0 01-2.25-2.25V6.23a2.25 2.25 0 012.25-2.25h15a2.25 2.25 0 012.25 2.25z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5l8.25 5.25L19.5 7.5"/></svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-sm text-(--color-smoke)">Email Notifications</h4>
                        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Receive notifications on your email</p>
                    </div>
                </div>
                <button wire:click="$set('emailNotifications', !{{ $emailNotifications }})"
                        class="set-toggle relative w-11 h-6 rounded-full"
                        style="background: {{ $emailNotifications ? 'var(--color-terra)' : 'rgba(30,41,59,0.15)' }};">
                    <span class="set-toggle-knob absolute top-0.5 w-5 h-5 rounded-full bg-white shadow-sm {{ $emailNotifications ? 'translate-x-5.5' : 'translate-x-0.5' }}"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Video Quality -->
    <div class="rounded-2xl p-6 set-fade-up set-fade-up-3" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-5">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #22c55e, rgba(34,197,94,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">Video Quality</h2>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <label class="relative cursor-pointer">
                <input type="radio" wire:model="videoQuality" value="360p" class="peer sr-only">
                <div class="p-4 rounded-xl text-center transition-all peer-checked:ring-2 peer-checked:ring-[rgba(245,130,32,0.4)] peer-checked:bg-[rgba(245,130,32,0.04)]" style="border: 1px solid rgba(30,41,59,.06); background: rgba(255,255,255,.5);">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2" style="background: rgba(34,197,94,.08);">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                    </div>
                    <span class="text-sm font-bold text-(--color-smoke)">360p</span>
                    <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-0.5">Low Data</p>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" wire:model="videoQuality" value="480p" class="peer sr-only">
                <div class="p-4 rounded-xl text-center transition-all peer-checked:ring-2 peer-checked:ring-[rgba(245,130,32,0.4)] peer-checked:bg-[rgba(245,130,32,0.04)]" style="border: 1px solid rgba(30,41,59,.06); background: rgba(255,255,255,.5);">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2" style="background: rgba(59,130,246,.08);">
                        <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5"/></svg>
                    </div>
                    <span class="text-sm font-bold text-(--color-smoke)">480p</span>
                    <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-0.5">Standard</p>
                </div>
            </label>
            <label class="relative cursor-pointer">
                <input type="radio" wire:model="videoQuality" value="720p" class="peer sr-only">
                <div class="p-4 rounded-xl text-center transition-all peer-checked:ring-2 peer-checked:ring-[rgba(245,130,32,0.4)] peer-checked:bg-[rgba(245,130,32,0.04)]" style="border: 1px solid rgba(30,41,59,.06); background: rgba(255,255,255,.5);">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2" style="background: rgba(245,130,32,.08);">
                        <svg class="w-5 h-5" style="color: #f58220;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                    </div>
                    <span class="text-sm font-bold text-(--color-smoke)">720p</span>
                    <p class="text-[.5625rem] text-[rgba(30,41,59,0.4)] mt-0.5">HD</p>
                </div>
            </label>
        </div>
        <p class="text-[.625rem] text-[rgba(30,41,59,0.4)] mt-3 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            Select 360p to save your mobile data
        </p>
    </div>

    <!-- Security -->
    <div class="rounded-2xl p-6 set-fade-up set-fade-up-4" style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 6px 24px rgba(0,0,0,.04);">
        <div class="flex items-center gap-2.5 mb-5">
            <div class="w-1 h-6 rounded-full" style="background: linear-gradient(180deg, #ef4444, rgba(239,68,68,.2));"></div>
            <h2 class="text-base font-bold text-(--color-smoke)">Security</h2>
        </div>
        <div class="flex items-center justify-between p-4 rounded-xl" style="border: 1px solid rgba(30,41,59,.04); background: rgba(255,255,255,.5);">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,.08);">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-(--color-smoke)">Change Password</h4>
                    <p class="text-[.625rem] text-[rgba(30,41,59,0.4)]">Update your account password</p>
                </div>
            </div>
            <a href="{{ route('password.request') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-[.6875rem] font-semibold transition-all hover:scale-105 active:scale-95" style="background: rgba(239,68,68,.08); color: #dc2626;">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                Update
            </a>
        </div>
    </div>
</div>