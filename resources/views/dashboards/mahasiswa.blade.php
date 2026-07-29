<x-layouts::app :title="__('Mahasiswa Dashboard')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Mahasiswa Dashboard</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <flux:badge color="emerald" class="px-3 py-1.5 text-xs font-medium uppercase tracking-wider">Mahasiswa</flux:badge>
        </div>

        @php
            $mhs = auth()->user()->mahasiswaProfile;
            $aktifCount = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)->where('status', 'aktif')->count() : 0;
            $pendingCount = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)->where('status', 'pending')->count() : 0;
            $presensiCount = $mhs ? \App\Models\Presensi::where('mahasiswa_id', $mhs->id)->count() : 0;
        @endphp

        <div class="grid gap-5 sm:grid-cols-3">
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $aktifCount }}</p>
                <p class="mt-1 text-sm text-zinc-500">Kelas Aktif</p>
            </div>
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $pendingCount }}</p>
                <p class="mt-1 text-sm text-zinc-500">KRS Pending</p>
            </div>
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $presensiCount }}</p>
                <p class="mt-1 text-sm text-zinc-500">Total Presensi</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Kelas Aktif Saya</h2>
                <div class="mt-4 space-y-3">
                    @php
                        $kelasAktif = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)
                            ->where('status', 'aktif')
                            ->with(['kelasKuliah.mataKuliah', 'kelasKuliah.dosen'])
                            ->get() : collect();
                    @endphp
                    @forelse($kelasAktif as $krs)
                        <div class="rounded-xl border border-zinc-100/80 bg-zinc-50/50 p-3.5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</p>
                            <p class="mt-0.5 text-xs text-zinc-500">{{ $krs->kelasKuliah->nama_kelas }} · {{ $krs->kelasKuliah->dosen->nama_lengkap ?? '-' }}</p>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-zinc-400">Belum ada kelas aktif</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Akses Cepat</h2>
                <div class="mt-4 grid gap-2">
                    <a href="{{ route('mhs.krs.index') }}" class="group flex items-center gap-3 rounded-xl bg-zinc-50/50 p-3.5 hover:bg-emerald-50/50 dark:bg-zinc-800/50 dark:hover:bg-emerald-900/10 transition-all" wire:navigate>
                        <flux:icon.academic-cap class="size-5 text-emerald-600 shrink-0" />
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">Ambil Kelas (KRS)</p>
                            <p class="text-xs text-zinc-500">Pilih dan daftar ke kelas yang tersedia</p>
                        </div>
                    </a>
                    <a href="{{ route('mhs.presensi.index') }}" class="group flex items-center gap-3 rounded-xl bg-zinc-50/50 p-3.5 hover:bg-emerald-50/50 dark:bg-zinc-800/50 dark:hover:bg-emerald-900/10 transition-all" wire:navigate>
                        <flux:icon.check-circle class="size-5 text-emerald-600 shrink-0" />
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">Presensi Hari Ini</p>
                            <p class="text-xs text-zinc-500">Isi presensi untuk sesi yang sedang berlangsung</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
