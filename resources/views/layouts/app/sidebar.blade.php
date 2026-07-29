<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 antialiased">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-emerald-100/50 bg-white dark:border-emerald-900/20 dark:bg-zinc-900">
            <flux:sidebar.header class="border-b border-emerald-100/30 dark:border-emerald-900/20">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <div class="flex-1 overflow-y-auto px-2 py-4">
                <flux:sidebar.nav>
                    <flux:sidebar.group :heading="__('Menu Utama')" class="mt-0">
                        <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="group">
                            {{ __('Dashboard') }}
                        </flux:sidebar.item>
                    </flux:sidebar.group>

                    @if(auth()->user()->role === 'admin')
                        <flux:sidebar.group :heading="__('Administrasi')">
                            <flux:sidebar.item icon="users" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                                {{ __('Users') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="academic-cap" :href="route('admin.prodi.index')" :current="request()->routeIs('admin.prodi.*')" wire:navigate>
                                {{ __('Program Studi') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="book-open" :href="route('admin.mk.index')" :current="request()->routeIs('admin.mk.*')" wire:navigate>
                                {{ __('Mata Kuliah') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="user-group" :href="route('admin.kelas.index')" :current="request()->routeIs('admin.kelas.*')" wire:navigate>
                                {{ __('Kelas') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="clipboard-document-check" :href="route('admin.krs.index')" :current="request()->routeIs('admin.krs.*')" wire:navigate>
                                {{ __('KRS') }}
                            </flux:sidebar.item>
                        </flux:sidebar.group>
                    @endif

                    @if(auth()->user()->role === 'dosen')
                        <flux:sidebar.group :heading="__('Perkuliahan')">
                            <flux:sidebar.item icon="calendar" :href="route('dosen.jadwal.index')" :current="request()->routeIs('dosen.jadwal.*')" wire:navigate>
                                {{ __('Jadwal & Pertemuan') }}
                            </flux:sidebar.item>
                        </flux:sidebar.group>
                    @endif

                    @if(auth()->user()->role === 'mahasiswa')
                        <flux:sidebar.group :heading="__('Akademik')">
                            <flux:sidebar.item icon="academic-cap" :href="route('mhs.krs.index')" :current="request()->routeIs('mhs.krs.*')" wire:navigate>
                                {{ __('Ambil Kelas (KRS)') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="check-circle" :href="route('mhs.presensi.index')" :current="request()->routeIs('mhs.presensi.*')" wire:navigate>
                                {{ __('Presensi') }}
                            </flux:sidebar.item>
                        </flux:sidebar.group>
                    @endif
                </flux:sidebar.nav>
            </div>

            <div class="border-t border-emerald-100/30 px-2 py-3 dark:border-emerald-900/20">
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            </div>
        </flux:sidebar>

        <flux:header class="lg:hidden border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-800">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <div class="flex items-center gap-2">
                <x-app-logo-icon class="size-7 text-emerald-600 dark:text-emerald-400" />
                <span class="text-sm font-semibold text-zinc-800 dark:text-white">SIPRESMA</span>
            </div>
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />
                <flux:menu>
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <flux:avatar
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                        />
                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                        </div>
                    </div>
                    <flux:menu.separator />
                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
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
