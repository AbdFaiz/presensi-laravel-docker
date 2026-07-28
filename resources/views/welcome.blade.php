<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Presensi Kampus') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 antialiased">
        <div class="relative min-h-screen flex flex-col">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4 px-6 py-5">
                    @auth
                        <flux:button href="{{ route('dashboard') }}" icon-trailing="arrow-right">
                            Dashboard
                        </flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" variant="ghost">Masuk</flux:button>
                        @if (Route::has('register'))
                            <flux:button href="{{ route('register') }}" variant="primary">Daftar</flux:button>
                        @endif
                    @endauth
                </nav>
            @endif

            <main class="flex-1 flex flex-col items-center justify-center px-6 py-12">
                <div class="flex flex-col items-center text-center max-w-2xl">
                    <div class="mb-8">
                        <div class="flex items-center justify-center w-20 h-20 rounded-2xl bg-blue-600 shadow-lg shadow-blue-200 dark:shadow-blue-900/30">
                            <x-app-logo-icon class="w-12 h-12 fill-white" />
                        </div>
                    </div>

                    <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ config('app.name', 'Presensi Kampus') }}
                    </h1>

                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 max-w-lg">
                        Sistem presensi terintegrasi untuk perkuliahan. Catat kehadiran, kelola KRS, dan pantau aktivitas akademik secara real-time.
                    </p>

                    <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                        @auth
                            <flux:button href="{{ route('dashboard') }}" size="base" icon-trailing="arrow-right">
                                Buka Dashboard
                            </flux:button>
                        @else
                            <flux:button href="{{ route('login') }}" size="base" icon-trailing="arrow-right">
                                Mulai Presensi
                            </flux:button>
                            @if (Route::has('register'))
                                <flux:button href="{{ route('register') }}" size="base" variant="subtle">
                                    Daftar Akun
                                </flux:button>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="mt-20 grid grid-cols-1 sm:grid-cols-3 gap-6 w-full max-w-3xl">
                    <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white/70 dark:bg-white/5 border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mb-4">
                            <flux:icon.clipboard-document-check class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Presensi</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Isi kehadiran perkuliahan dengan cepat</p>
                    </div>

                    <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white/70 dark:bg-white/5 border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                        <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/50 flex items-center justify-center mb-4">
                            <flux:icon.book-open-text class="w-6 h-6 text-green-600 dark:text-green-400" />
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">KRS</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola rencana studi setiap semester</p>
                    </div>

                    <div class="flex flex-col items-center text-center p-6 rounded-xl bg-white/70 dark:bg-white/5 border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center mb-4">
                            <flux:icon.chart-bar class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Laporan</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pantau rekap kehadiran secara real-time</p>
                    </div>
                </div>
            </main>

            <footer class="py-6 text-center text-sm text-gray-400 dark:text-gray-600">
                &copy; {{ date('Y') }} {{ config('app.name', 'Presensi Kampus') }}. All rights reserved.
            </footer>
        </div>
    </body>
</html>
