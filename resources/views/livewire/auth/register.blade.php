<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-5">
        <!-- Header -->
        <div class="text-center mb-1">
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--color-ivory);letter-spacing:-.01em;margin-bottom:.35rem">Create your account</h2>
            <p style="font-size:.9rem;color:rgba(248,249,250,.5)">Start your English learning journey today</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-4">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <button type="submit" class="auth-submit-btn" data-test="register-user-button">
                {{ __('Create account') }}
            </button>
        </form>

        <div class="auth-divider">or</div>

        <div class="auth-alt-link">
            <span>{{ __('Already have an account?') }}</span>
            <a href="{{ route('login') }}" wire:navigate>{{ __('Log in') }}</a>
        </div>
    </div>
</x-layouts::auth>
