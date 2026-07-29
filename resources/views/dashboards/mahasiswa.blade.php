<x-layouts::app :title="__('Mahasiswa Dashboard')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Mahasiswa Dashboard</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:bg-slate-800/50 dark:text-slate-400">Mahasiswa</span>
        </div>

        @php
            $mhs = auth()->user()->mahasiswaProfile;
            $aktifCount = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)->where('status', 'aktif')->count() : 0;
            $pendingCount = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)->where('status', 'pending')->count() : 0;
            $presensiCount = $mhs ? \App\Models\Presensi::where('mahasiswa_id', $mhs->id)->count() : 0;
        @endphp

        <div class="grid gap-4 sm:gap-5 sm:grid-cols-3">
            <div class="card-unas p-6">
                <span class="flex size-11 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                    <flux:icon.book-open class="size-5" />
                </span>
                <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white">{{ $aktifCount }}</p>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelas Aktif</p>
            </div>
            <div class="card-unas p-6">
                <span class="flex size-11 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400">
                    <flux:icon.clock class="size-5" />
                </span>
                <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white">{{ $pendingCount }}</p>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">KRS Pending</p>
            </div>
            <div class="card-unas p-6">
                <span class="flex size-11 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                    <flux:icon.check-circle class="size-5" />
                </span>
                <p class="mt-4 text-3xl font-bold text-slate-900 dark:text-white">{{ $presensiCount }}</p>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Total Presensi</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="card-unas p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                        <flux:icon.book-open class="size-4" />
                    </span>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Kelas Aktif Saya</h2>
                </div>
                <div class="space-y-3">
                    @php
                        $kelasAktif = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)->where('status', 'aktif')->with(['kelasKuliah.mataKuliah', 'kelasKuliah.dosen'])->get() : collect();
                    @endphp
                    @forelse($kelasAktif as $krs)
                        <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50/40 p-3.5 dark:border-slate-800 dark:bg-slate-900/10">
                            <div>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</p>
                                <p class="mt-0.5 text-xs text-slate-600 dark:text-slate-400">{{ $krs->kelasKuliah->nama_kelas }} · {{ $krs->kelasKuliah->dosen->nama_lengkap ?? '-' }}</p>
                            </div>
                            <span class="badge-aktif shrink-0"><flux:icon.check class="size-3" /> Aktif</span>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">Belum ada kelas aktif</p>
                    @endforelse
                </div>
            </div>

            <div class="card-unas p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400">
                        <flux:icon.sparkles class="size-4" />
                    </span>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Akses Cepat</h2>
                </div>
                <div class="grid gap-2">
                    <a href="{{ route('mhs.krs.index') }}"
                        class="group flex items-center gap-3 rounded-lg border border-slate-200 bg-white p-3.5 hover:border-blue-300 transition-all dark:bg-slate-900 dark:border-slate-800 dark:hover:border-blue-600"
                        wire:navigate>
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-slate-800/50 dark:text-amber-400">
                            <flux:icon.building-library class="size-4" />
                        </span>
                        <div>
                            <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">Ambil Kelas (KRS)</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pilih dan daftar ke kelas yang tersedia</p>
                        </div>
                    </a>
                    <a href="{{ route('mhs.presensi.index') }}"
                        class="group flex items-center gap-3 rounded-lg border border-slate-200 bg-white p-3.5 hover:border-blue-300 transition-all dark:bg-slate-900 dark:border-slate-800 dark:hover:border-blue-600"
                        wire:navigate>
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                            <flux:icon.check-circle class="size-4" />
                        </span>
                        <div>
                            <p class="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors dark:text-white dark:group-hover:text-blue-400">Presensi Hari Ini</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Isi presensi untuk sesi yang sedang berlangsung</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
