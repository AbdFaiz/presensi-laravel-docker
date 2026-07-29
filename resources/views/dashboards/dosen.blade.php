<x-layouts::app :title="__('Dosen Dashboard')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Dosen Dashboard</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:bg-slate-800/50 dark:text-slate-400">Dosen</span>
        </div>

        @php
            $dosen = auth()->user()->dosenProfile;
            $kelasList = $dosen ? $dosen->kelasKuliahs()->with(['mataKuliah'])->get() : collect();
            $totalMhs = $dosen ? \App\Models\KrsDetail::where('status', 'aktif')->whereIn('kelas_kuliah_id', $kelasList->pluck('id'))->count() : 0;
            $sesiAktif = $dosen ? \App\Models\JadwalKuliah::where('status_sesi', 'dibuka')->whereIn('kelas_kuliah_id', $kelasList->pluck('id'))->count() : 0;
        @endphp

        <div class="grid gap-4 sm:gap-5 sm:grid-cols-3">
            <div class="card-unas p-6">
                <span class="flex size-11 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                    <flux:icon.user-group class="size-5" />
                </span>
                <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white">{{ $kelasList->count() }}</p>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelas Diampu</p>
            </div>
            <div class="card-unas p-6">
                <span class="flex size-11 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400">
                    <flux:icon.users class="size-5" />
                </span>
                <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white">{{ $totalMhs }}</p>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Total Mahasiswa</p>
            </div>
            <div class="card-unas p-6">
                <span class="flex size-11 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                    <flux:icon.play class="size-5" />
                </span>
                <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white">{{ $sesiAktif }}</p>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Sesi Aktif</p>
            </div>
        </div>

        <div class="card-unas p-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="flex size-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                    <flux:icon.book-open class="size-4" />
                </span>
                <h2 class="text-base font-semibold text-slate-900 dark:text-white">Kelas Saya</h2>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                @forelse($kelasList as $kelas)
                    <div class="group flex items-center justify-between rounded-lg border border-slate-200 bg-white p-4 hover:border-blue-300 transition-all dark:bg-slate-900 dark:border-slate-800 dark:hover:border-blue-600">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $kelas->nama_kelas }}</p>
                            <p class="mt-0.5 text-xs text-slate-600 dark:text-slate-400">{{ $kelas->mataKuliah->nama_mk ?? '-' }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $kelas->tahun_akademik }}</p>
                        </div>
                        <a href="{{ route('dosen.jadwal.index') }}"
                            class="inline-flex items-center gap-1 text-xs font-medium text-amber-600 hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300"
                            wire:navigate>
                            Jadwal <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                @empty
                    <p class="col-span-2 py-6 text-center text-sm text-slate-400 dark:text-slate-500">Belum ada kelas diampu</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>
