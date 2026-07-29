@props([
    'sidebar' => false,
])

@if ($sidebar)
    <flux:sidebar.brand :name="config('app.name', 'Sihadir')" {{ $attributes }}>
        <x-slot name="logo"
            class="flex aspect-square size-8 items-center justify-center rounded-md bg-blue-600 text-white">
            <x-app-logo-icon class="size-5 fill-current text-white" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="config('app.name', 'Sihadir')" {{ $attributes }}>
        <x-slot name="logo"
            class="flex aspect-square size-10 items-center justify-center rounded-lg bg-blue-600 text-white">
            <x-app-logo-icon class="size-6 fill-current text-white" />
        </x-slot>
    </flux:brand>
@endif
