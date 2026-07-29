<x-layouts::app :title="__('Dosen Dashboard')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Dosen Dashboard</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <flux:badge color="blue" class="px-3 py-1.5 text-xs font-medium uppercase tracking-wider">Dosen</flux:badge>
        </div>

        @php
            $dosen = auth()->user()->dosenProfile;
            $kelasList = $dosen ? $dosen->kelasKuliahs()->with(['mataKuliah'])->get() : collect();
            $totalMhs = $dosen ? \App\Models\KrsDetail::where('status', 'aktif')->whereIn('kelas_kuliah_id', $kelasList->pluck('id'))->count() : 0;
            $sesiAktif = $dosen ? \App\Models\JadwalKuliah::where('status_sesi', 'dibuka')->whereIn('kelas_kuliah_id', $kelasList->pluck('id'))->count() : 0;
        @endphp

        <div class="grid gap-5 sm:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $kelasList->count() }}</p>
                <p class="mt-1 text-sm text-zinc-500">Kelas Diampu</p>
            </div>
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $totalMhs }}</p>
                <p class="mt-1 text-sm text-zinc-500">Total Mahasiswa</p>
            </div>
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $sesiAktif }}</p>
                <p class="mt-1 text-sm text-zinc-500">Sesi Aktif</p>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Kelas Saya</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                @forelse($kelasList as $kelas)
                    <div class="group flex items-center justify-between rounded-xl border border-zinc-100/80 bg-zinc-50/50 p-4 dark:border-zinc-700/50 dark:bg-zinc-800/50 hover:border-emerald-200 hover:bg-emerald-50/50 dark:hover:border-emerald-800 dark:hover:bg-emerald-900/10 transition-all">
                        <div>
                            <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $kelas->nama_kelas }}</p>
                            <p class="mt-0.5 text-xs text-zinc-500">{{ $kelas->mataKuliah->nama_mk ?? '-' }}</p>
                            <p class="text-xs text-zinc-400">{{ $kelas->tahun_akademik }}</p>
                        </div>
                        <a href="{{ route('dosen.jadwal.index') }}" class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300" wire:navigate>
                            Jadwal <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                @empty
                    <p class="col-span-2 py-6 text-center text-sm text-zinc-400">Belum ada kelas diampu</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>
