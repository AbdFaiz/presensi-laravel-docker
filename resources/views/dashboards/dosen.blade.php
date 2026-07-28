<x-layouts::app :title="__('Dosen Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <flux:heading size="xl">Selamat Datang, {{ auth()->user()->name }}</flux:heading>
            <flux:text class="mt-1">Panel Dosen Pengampu</flux:text>
        </div>

        @php
            $dosen = auth()->user()->dosenProfile;
            $kelasList = $dosen ? $dosen->kelasKuliahs()->with(['mataKuliah'])->get() : collect();
        @endphp

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Kelas Diampu</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ $kelasList->count() }}</div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Total Mahasiswa</flux:text>
                <div class="mt-2 text-3xl font-bold">
                    {{ \App\Models\KrsDetail::where('status', 'aktif')->whereIn('kelas_kuliah_id', $kelasList->pluck('id'))->count() }}
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Sesi Aktif</flux:text>
                <div class="mt-2 text-3xl font-bold">
                    {{ \App\Models\JadwalKuliah::where('status_sesi', 'dibuka')->whereIn('kelas_kuliah_id', $kelasList->pluck('id'))->count() }}
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
            <flux:heading size="sm">Kelas Saya</flux:heading>
            <div class="mt-4 space-y-2">
                @forelse($kelasList as $kelas)
                    <div class="flex items-center justify-between rounded-lg border border-neutral-100 p-3 dark:border-neutral-600">
                        <div>
                            <div class="font-medium">{{ $kelas->nama_kelas }} - {{ $kelas->mataKuliah->nama_mk ?? '-' }}</div>
                            <div class="text-sm text-zinc-500">{{ $kelas->tahun_akademik }} | SKS: {{ $kelas->mataKuliah->sks ?? '-' }}</div>
                        </div>
                        <a href="{{ route('dosen.jadwal.index') }}" class="text-sm text-blue-600 hover:underline" wire:navigate>Lihat Jadwal</a>
                    </div>
                @empty
                    <flux:text class="text-zinc-400">Belum ada kelas diampu</flux:text>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>
