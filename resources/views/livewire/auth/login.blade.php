<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-5">
        <!-- Header -->
        <div class="text-center mb-1">
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--color-ivory);letter-spacing:-.01em;margin-bottom:.35rem">Welcome back</h2>
            <p style="font-size:.9rem;color:rgba(248,249,250,.5)">Sign in to continue your learning journey</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm inset-e-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <button type="submit" class="auth-submit-btn" data-test="login-button">
                {{ __('Log in') }}
            </button>
        </form>

        <div class="auth-divider">or</div>

        @if (Route::has('register'))
            <div class="auth-alt-link">
                <span>{{ __("Don't have an account?") }}</span>
                <a href="{{ route('register') }}" wire:navigate>{{ __('Sign up free') }}</a>
            </div>
        @endif
    </div>
</x-layouts::auth>
