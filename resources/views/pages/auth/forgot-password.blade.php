<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-6">
        <div class="flex w-full flex-col text-center">
            <flux:heading size="xl">{{ __('Forgot password') }}</flux:heading>
            <flux:subheading class="mt-1">{{ __('Enter your email to receive a password reset link') }}</flux:subheading>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="email"
                :label="__('Email address')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button variant="primary" type="submit" class="btn-primary w-full" data-test="email-password-reset-link-button">
                {{ __('Email password reset link') }}
            </flux:button>
        </form>

        <div class="text-center text-sm text-slate-400">
            <span>{{ __('Or, return to') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
