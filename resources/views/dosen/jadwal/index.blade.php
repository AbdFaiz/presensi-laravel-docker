<x-layouts::app :title="__('Jadwal Pertemuan')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Jadwal & Pertemuan</h1>
                <p class="mt-1 text-sm text-zinc-500">Kelola sesi pertemuan perkuliahan</p>
            </div>
            <a href="{{ route('dosen.jadwal.create') }}" wire:navigate>
                <flux:button icon="plus" class="!bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-sm">Tambah Pertemuan</flux:button>
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl border border-zinc-200/60 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Pertemuan</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Mata Kuliah</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Tanggal</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Jam</th>
                            <th class="px-5 py-4 text-center font-medium text-zinc-500">Status</th>
                            <th class="px-5 py-4 text-right font-medium text-zinc-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @forelse($jadwals as $jadwal)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/5 transition-colors">
                                <td class="px-5 py-4 font-bold text-zinc-900 dark:text-white">Pertemuan {{ $jadwal->pertemuan_ke }}</td>
                                <td class="px-5 py-4">{{ $jadwal->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-5 py-4 text-zinc-600">{{ $jadwal->tgl_pertemuan->format('d/m/Y') }}</td>
                                <td class="px-5 py-4 font-mono text-sm">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                <td class="px-5 py-4 text-center">
                                    @if($jadwal->status_sesi === 'dibuka')
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Dibuka</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">Ditutup</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <form method="POST" action="{{ route('dosen.jadwal.toggle', $jadwal) }}" class="inline">
                                        @csrf @method('PUT')
                                        @if($jadwal->status_sesi === 'dibuka')
                                            <flux:button size="xs" icon="stop" type="submit" class="!bg-amber-500 !text-white hover:!bg-amber-600">Tutup Sesi</flux:button>
                                        @else
                                            <flux:button size="xs" icon="play" type="submit" class="!bg-emerald-600 !text-white hover:!bg-emerald-700">Buka Sesi</flux:button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-zinc-400">Belum ada jadwal pertemuan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
