<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sihadir') }}</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 dark:bg-slate-950 antialiased">
    <div class="relative min-h-screen flex flex-col">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-3 px-8 py-5">
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

        <main class="flex-1 flex flex-col items-center justify-center px-6 py-16">
            <div class="flex flex-col items-center text-center max-w-3xl">
                <div class="mb-8">
                    <div
                        class="flex items-center justify-center w-20 h-20 rounded-lg bg-blue-600">
                        <x-app-logo-icon class="w-12 h-12 fill-white" />
                    </div>
                </div>

                <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Sihadir
                </h1>
                <p class="mt-3 text-base font-medium text-blue-600 dark:text-blue-400">
                    Sistem Presensi Mahasiswa
                </p>

                <p class="mt-6 text-lg text-slate-500 dark:text-slate-400 max-w-xl leading-relaxed">
                    Platform presensi perkuliahan terintegrasi. Catat kehadiran, kelola KRS, dan pantau aktivitas
                    akademik secara real-time.
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    @auth
                        <flux:button href="{{ route('dashboard') }}" size="base" icon-trailing="arrow-right"
                            class="!bg-blue-600 !text-white hover:!bg-blue-700">
                            Buka Dashboard
                        </flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" size="base" icon-trailing="arrow-right"
                            class="!bg-blue-600 !text-white hover:!bg-blue-700">
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

            <div class="mt-24 grid grid-cols-1 sm:grid-cols-3 gap-6 w-full max-w-4xl">
                <div
                    class="group flex flex-col items-center text-center p-8 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-200">
                    <div
                        class="w-12 h-12 rounded-lg bg-blue-50 dark:bg-slate-800/50 flex items-center justify-center mb-4">
                        <flux:icon.clipboard-document-check class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">Presensi</h3>
                    <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Isi kehadiran perkuliahan
                        dengan cepat dan mudah</p>
                </div>

                <div
                    class="group flex flex-col items-center text-center p-8 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-200">
                    <div
                        class="w-12 h-12 rounded-lg bg-blue-50 dark:bg-slate-800/50 flex items-center justify-center mb-4">
                        <flux:icon.book-open-text class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">KRS</h3>
                    <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Kelola rencana studi
                        setiap semester secara mandiri</p>
                </div>

                <div
                    class="group flex flex-col items-center text-center p-8 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-200">
                    <div
                        class="w-12 h-12 rounded-lg bg-blue-50 dark:bg-slate-800/50 flex items-center justify-center mb-4">
                        <flux:icon.chart-bar class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <h3 class="font-semibold text-slate-900 dark:text-white">Laporan</h3>
                    <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Pantau rekap kehadiran
                        secara real-time</p>
                </div>
            </div>
        </main>

        <footer class="py-8 text-center text-sm text-slate-400 dark:text-slate-600">
            &copy; {{ date('Y') }} Sihadir. All rights reserved.
        </footer>
    </div>
</body>

</html>
