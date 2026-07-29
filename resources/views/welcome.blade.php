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

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 antialiased">
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
                        class="flex items-center justify-center w-20 h-20 rounded-2xl bg-emerald-600 shadow-lg shadow-emerald-200/50 dark:shadow-emerald-900/30">
                        <x-app-logo-icon class="w-12 h-12 fill-white" />
                    </div>
                </div>

                <h1 class="text-5xl sm:text-6xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    Sihadir
                </h1>
                <p class="mt-3 text-base font-medium text-emerald-600 dark:text-emerald-400">
                    Sistem Presensi Mahasiswa
                </p>

                <p class="mt-6 text-lg text-zinc-500 dark:text-zinc-400 max-w-xl leading-relaxed">
                    Platform presensi perkuliahan terintegrasi. Catat kehadiran, kelola KRS, dan pantau aktivitas
                    akademik secara real-time.
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    @auth
                        <flux:button href="{{ route('dashboard') }}" size="base" icon-trailing="arrow-right"
                            class="!bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-lg shadow-emerald-200/50 dark:shadow-emerald-900/30">
                            Buka Dashboard
                        </flux:button>
                    @else
                        <flux:button href="{{ route('login') }}" size="base" icon-trailing="arrow-right"
                            class="!bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-lg shadow-emerald-200/50 dark:shadow-emerald-900/30">
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
                    class="group flex flex-col items-center text-center p-8 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-800 transition-all duration-200">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <flux:icon.clipboard-document-check class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">Presensi</h3>
                    <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">Isi kehadiran perkuliahan
                        dengan cepat dan mudah</p>
                </div>

                <div
                    class="group flex flex-col items-center text-center p-8 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-800 transition-all duration-200">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <flux:icon.book-open-text class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">KRS</h3>
                    <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">Kelola rencana studi
                        setiap semester secara mandiri</p>
                </div>

                <div
                    class="group flex flex-col items-center text-center p-8 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800 shadow-sm hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-800 transition-all duration-200">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <flux:icon.chart-bar class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">Laporan</h3>
                    <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">Pantau rekap kehadiran
                        secara real-time</p>
                </div>
            </div>
        </main>

        <footer class="py-8 text-center text-sm text-zinc-400 dark:text-zinc-600">
            &copy; {{ date('Y') }} Sihadir. All rights reserved.
        </footer>
    </div>
</body>

</html>
