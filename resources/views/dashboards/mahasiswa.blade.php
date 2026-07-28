<x-layouts::app :title="__('Mahasiswa Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <flux:heading size="xl">Selamat Datang, {{ auth()->user()->name }}</flux:heading>
            <flux:text class="mt-1">Panel Mahasiswa</flux:text>
        </div>

        @php
            $mhs = auth()->user()->mahasiswaProfile;
            $aktifCount = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)->where('status', 'aktif')->count() : 0;
            $pendingCount = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)->where('status', 'pending')->count() : 0;
            $presensiCount = $mhs ? \App\Models\Presensi::where('mahasiswa_id', $mhs->id)->count() : 0;
        @endphp

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Kelas Aktif</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ $aktifCount }}</div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">KRS Pending</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ $pendingCount }}</div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Total Presensi</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ $presensiCount }}</div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:heading size="sm">Kelas Aktif Saya</flux:heading>
                <div class="mt-4 space-y-2">
                    @php
                        $kelasAktif = $mhs ? \App\Models\KrsDetail::where('mahasiswa_id', $mhs->id)
                            ->where('status', 'aktif')
                            ->with(['kelasKuliah.mataKuliah', 'kelasKuliah.dosen'])
                            ->get() : collect();
                    @endphp
                    @forelse($kelasAktif as $krs)
                        <div class="rounded-lg border border-neutral-100 p-3 dark:border-neutral-600">
                            <div class="font-medium">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</div>
                            <div class="text-sm text-zinc-500">{{ $krs->kelasKuliah->nama_kelas }} | {{ $krs->kelasKuliah->dosen->nama_lengkap ?? '-' }}</div>
                        </div>
                    @empty
                        <flux:text class="text-zinc-400">Belum ada kelas aktif</flux:text>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:heading size="sm">Akses Cepat</flux:heading>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('mhs.krs.index') }}" class="block rounded-lg border border-neutral-100 p-3 hover:bg-zinc-50 dark:border-neutral-600 dark:hover:bg-zinc-700" wire:navigate>
                        <div class="font-medium">Ambil Kelas (KRS)</div>
                        <div class="text-sm text-zinc-500">Pilih dan daftar ke kelas yang tersedia</div>
                    </a>
                    <a href="{{ route('mhs.presensi.index') }}" class="block rounded-lg border border-neutral-100 p-3 hover:bg-zinc-50 dark:border-neutral-600 dark:hover:bg-zinc-700" wire:navigate>
                        <div class="font-medium">Presensi Hari Ini</div>
                        <div class="text-sm text-zinc-500">Isi presensi untuk sesi yang sedang berlangsung</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
