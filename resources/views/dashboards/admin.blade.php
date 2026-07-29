<x-layouts::app :title="__('Admin Dashboard')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Admin Dashboard</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Selamat datang kembali, {{ auth()->user()->name }}</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:bg-slate-800/50 dark:text-slate-400">Administrator</span>
        </div>

        <div class="grid gap-4 sm:gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['label' => 'Total Users', 'value' => \App\Models\User::count(), 'icon' => 'users', 'color' => 'emerald'],
                    ['label' => 'Program Studi', 'value' => \App\Models\ProgramStudi::count(), 'icon' => 'building-library', 'color' => 'amber'],
                    ['label' => 'Mata Kuliah', 'value' => \App\Models\MataKuliah::count(), 'icon' => 'book-open', 'color' => 'emerald'],
                    ['label' => 'Kelas Aktif', 'value' => \App\Models\KelasKuliah::count(), 'icon' => 'user-group', 'color' => 'amber'],
                ];
            @endphp
            @foreach ($stats as $s)
                <div class="card-unas p-6 transition-all">
                    <div class="flex items-center justify-between">
                        <span class="flex size-11 items-center justify-center rounded-lg {{ $s['color'] === 'amber' ? 'bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400' : 'bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400' }}">
                            <flux:icon name="{{ $s['icon'] }}" class="size-5" />
                        </span>
                    </div>
                    <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white">{{ $s['value'] }}</p>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="card-unas p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400">
                        <flux:icon.clipboard-document-list class="size-4" />
                    </span>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">KRS Menunggu Persetujuan</h2>
                </div>
                <div class="space-y-3">
                    @php
                        $pending = \App\Models\KrsDetail::where('status', 'pending')
                            ->with(['mahasiswa', 'kelasKuliah.mataKuliah'])
                            ->limit(5)->get();
                    @endphp
                    @forelse($pending as $krs)
                        <div class="flex items-center justify-between rounded-lg border border-amber-200 bg-amber-50/40 p-3.5 dark:border-amber-800 dark:bg-amber-900/10">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $krs->mahasiswa->nama_lengkap ?? '-' }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-400 truncate">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }} ({{ $krs->kelasKuliah->nama_kelas ?? '-' }})</p>
                            </div>
                            <span class="badge-pending shrink-0"><flux:icon.clock class="size-3" /> Pending</span>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">Tidak ada KRS pending</p>
                    @endforelse
                </div>
            </div>

            <div class="card-unas p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                        <flux:icon.sparkles class="size-4" />
                    </span>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Akses Cepat</h2>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    @php
                        $links = [
                            ['route' => 'admin.users.index', 'label' => 'Kelola Users', 'desc' => 'Manajemen akun pengguna', 'icon' => 'users'],
                            ['route' => 'admin.prodi.index', 'label' => 'Program Studi', 'desc' => 'Kelola data program studi', 'icon' => 'building-library'],
                            ['route' => 'admin.mk.index', 'label' => 'Mata Kuliah', 'desc' => 'Kelola data mata kuliah', 'icon' => 'book-open'],
                            ['route' => 'admin.kelas.index', 'label' => 'Kelas', 'desc' => 'Kelola kelas dan pengampu', 'icon' => 'user-group'],
                            ['route' => 'admin.krs.index', 'label' => 'KRS', 'desc' => 'Setujui atau tolak pengajuan KRS', 'icon' => 'clipboard-document-check'],
                        ];
                        $icons = ['bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400', 'bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400', 'bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400', 'bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400', 'bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400'];
                    @endphp
                    @foreach ($links as $i => $link)
                        <a href="{{ route($link['route']) }}"
                            class="group flex items-center gap-3 rounded-lg border border-slate-200 bg-white p-3.5 hover:border-blue-300 transition-all dark:bg-slate-900 dark:border-slate-800 dark:hover:border-blue-600"
                            wire:navigate>
                            <span class="flex size-9 shrink-0 items-center justify-center rounded-lg {{ $icons[$i] }}">
                                <flux:icon name="{{ $link['icon'] }}" class="size-4" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">{{ $link['label'] }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $link['desc'] }}</p>
                            </div>
                            <flux:icon.chevron-right class="size-4 text-slate-300 group-hover:text-amber-500 transition-colors shrink-0 dark:text-slate-500 dark:group-hover:text-amber-400" />
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
