<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-slate-50 dark:bg-slate-950 antialiased">
    <flux:sidebar sticky collapsible="mobile" class="sidebar-unas">
        <flux:sidebar.header class="border-b border-slate-800">
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <div class="flex-1 overflow-y-auto px-2 py-4">
            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Menu Utama')" class="mt-0">
                    <flux:sidebar.item icon="home" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                @if (auth()->user()->role === 'admin')
                    <flux:sidebar.group :heading="__('Administrasi')">
                        <flux:sidebar.item icon="users" :href="route('admin.users.index')"
                            :current="request()->routeIs('admin.users.*')" wire:navigate>
                            {{ __('Users') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="academic-cap" :href="route('admin.prodi.index')"
                            :current="request()->routeIs('admin.prodi.*')" wire:navigate>
                            {{ __('Program Studi') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="book-open" :href="route('admin.mk.index')"
                            :current="request()->routeIs('admin.mk.*')" wire:navigate>
                            {{ __('Mata Kuliah') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="user-group" :href="route('admin.kelas.index')"
                            :current="request()->routeIs('admin.kelas.*')" wire:navigate>
                            {{ __('Kelas') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="clipboard-document-check" :href="route('admin.krs.index')"
                            :current="request()->routeIs('admin.krs.*')" wire:navigate>
                            {{ __('KRS') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif

                @if (auth()->user()->role === 'dosen')
                    <flux:sidebar.group :heading="__('Perkuliahan')">
                        <flux:sidebar.item icon="calendar" :href="route('dosen.jadwal.index')"
                            :current="request()->routeIs('dosen.jadwal.*')" wire:navigate>
                            {{ __('Jadwal & Pertemuan') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif

                @if (auth()->user()->role === 'mahasiswa')
                    <flux:sidebar.group :heading="__('Akademik')">
                        <flux:sidebar.item icon="book-open" :href="route('mhs.krs.index')"
                            :current="request()->routeIs('mhs.krs.index')" wire:navigate>
                            {{ __('Kelas Saya') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="plus-circle" :href="route('mhs.krs.daftar')"
                            :current="request()->routeIs('mhs.krs.daftar')" wire:navigate>
                            {{ __('Daftar Kelas Baru') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="check-circle" :href="route('mhs.presensi.index')"
                            :current="request()->routeIs('mhs.presensi.*')" wire:navigate>
                            {{ __('Presensi') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>
        </div>

        <div class="border-t border-slate-200 dark:border-slate-800 px-2 py-3">
            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </div>
    </flux:sidebar>

    <flux:header class="lg:hidden border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <div class="flex items-center gap-2">
            <x-app-logo-icon class="size-7 text-blue-600 dark:text-blue-400" />
            <span class="text-sm font-semibold text-slate-900 dark:text-white">Sihadir</span>
        </div>
        <flux:spacer />
    </flux:header>

    {{ $slot }}

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>
