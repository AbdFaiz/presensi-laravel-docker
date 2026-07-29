<x-layouts::app :title="__('Jadwal Pertemuan')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Jadwal & Pertemuan</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola sesi pertemuan perkuliahan</p>
            </div>
            <a href="{{ route('dosen.jadwal.create') }}" wire:navigate>
                <flux:button icon="plus" class="btn-accent">Tambah Pertemuan</flux:button>
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card-unas overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-unas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mata Kuliah</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $jadwal)
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4">
                                    <span class="inline-flex items-center justify-center size-8 rounded-lg bg-blue-50 text-blue-600 font-bold text-xs dark:bg-slate-800/50 dark:text-blue-400">{{ $jadwal->pertemuan_ke }}</span>
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-medium text-slate-900 dark:text-white">{{ $jadwal->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400">{{ $jadwal->tgl_pertemuan->format('d/m/Y') }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-mono text-xs text-slate-500 dark:text-slate-400">{{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-center">
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $jadwal->presensis_count }}</span>
                                    <span class="text-xs text-slate-400 dark:text-slate-600">/{{ $jadwal->total_mahasiswa }}</span>
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-center">
                                    @if($jadwal->status_sesi === 'dibuka')
                                        <span class="badge-aktif">
                                            <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Dibuka
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                            <span class="size-1.5 rounded-full bg-slate-400"></span>
                                            Ditutup
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dosen.presensi.show', $jadwal) }}" wire:navigate>
                                            <flux:button size="xs" variant="subtle" icon="eye">Presensi</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('dosen.jadwal.toggle', $jadwal) }}" class="inline" onsubmit="return confirm('{{ $jadwal->status_sesi === 'dibuka' ? 'Tutup sesi ini?' : 'Buka sesi presensi?' }}')">
                                            @csrf @method('PUT')
                                            @if($jadwal->status_sesi === 'dibuka')
                                                <flux:button size="xs" icon="stop" type="submit" class="!bg-amber-500 !text-white hover:!bg-amber-600">Tutup</flux:button>
                                            @else
                                                <flux:button size="xs" icon="play" type="submit" class="btn-primary">Buka</flux:button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-600">Belum ada jadwal pertemuan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
