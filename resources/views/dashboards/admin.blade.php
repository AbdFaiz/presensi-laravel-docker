<x-layouts::app :title="__('Admin Dashboard')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Admin Dashboard</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Selamat datang kembali, {{ auth()->user()->name }}</p>
            </div>
            <flux:badge color="emerald" class="px-3 py-1.5 text-xs font-medium uppercase tracking-wider">Administrator</flux:badge>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $stats = [
                    ['label' => 'Total Users', 'value' => \App\Models\User::count(), 'icon' => 'users', 'color' => 'emerald'],
                    ['label' => 'Program Studi', 'value' => \App\Models\ProgramStudi::count(), 'icon' => 'academic-cap', 'color' => 'blue'],
                    ['label' => 'Mata Kuliah', 'value' => \App\Models\MataKuliah::count(), 'icon' => 'book-open', 'color' => 'violet'],
                    ['label' => 'Kelas Aktif', 'value' => \App\Models\KelasKuliah::count(), 'icon' => 'user-group', 'color' => 'amber'],
                ];
            @endphp
            @foreach($stats as $s)
                <div class="group rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm hover:shadow-md hover:border-{{ $s['color'] }}-200 dark:border-zinc-800 dark:bg-zinc-900 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <flux:icon name="{{ $s['icon'] }}" class="size-5 text-zinc-400 dark:text-zinc-500" />
                    </div>
                    <p class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white">{{ $s['value'] }}</p>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $s['label'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-white">KRS Menunggu Persetujuan</h2>
                <div class="mt-4 space-y-3">
                    @php $pending = \App\Models\KrsDetail::where('status', 'pending')->with(['mahasiswa', 'kelasKuliah.mataKuliah'])->limit(5)->get(); @endphp
                    @forelse($pending as $krs)
                        <div class="flex items-center justify-between rounded-xl border border-zinc-100/80 bg-zinc-50/50 p-3.5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-zinc-900 truncate dark:text-white">{{ $krs->mahasiswa->nama_lengkap ?? '-' }}</p>
                                <p class="text-xs text-zinc-500 truncate">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }} ({{ $krs->kelasKuliah->nama_kelas ?? '-' }})</p>
                            </div>
                            <span class="shrink-0 inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Pending</span>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-zinc-400">Tidak ada KRS pending</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Akses Cepat</h2>
                <div class="mt-4 grid grid-cols-1 gap-2">
                    @php
                        $links = [
                            ['route' => 'admin.users.index', 'label' => 'Kelola Users', 'desc' => 'Manajemen akun pengguna', 'icon' => 'users'],
                            ['route' => 'admin.prodi.index', 'label' => 'Program Studi', 'desc' => 'Kelola data program studi', 'icon' => 'academic-cap'],
                            ['route' => 'admin.mk.index', 'label' => 'Mata Kuliah', 'desc' => 'Kelola data mata kuliah', 'icon' => 'book-open'],
                            ['route' => 'admin.kelas.index', 'label' => 'Kelas', 'desc' => 'Kelola kelas dan pengampu', 'icon' => 'user-group'],
                            ['route' => 'admin.krs.index', 'label' => 'KRS', 'desc' => 'Setujui atau tolak pengajuan KRS', 'icon' => 'clipboard-document-check'],
                        ];
                    @endphp
                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}" class="group flex items-center gap-3 rounded-xl border border-transparent bg-zinc-50/50 p-3.5 hover:border-emerald-200 hover:bg-emerald-50/50 dark:bg-zinc-800/50 dark:hover:border-emerald-800 dark:hover:bg-emerald-900/10 transition-all" wire:navigate>
                            <flux:icon name="{{ $link['icon'] }}" class="size-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $link['label'] }}</p>
                                <p class="text-xs text-zinc-500">{{ $link['desc'] }}</p>
                            </div>
                            <flux:icon.chevron-right class="size-4 text-zinc-300 dark:text-zinc-600 group-hover:text-emerald-500 transition-colors shrink-0" />
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
