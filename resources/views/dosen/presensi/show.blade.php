<x-layouts::app :title="__('Presensi - Pertemuan :num', ['num' => $jadwalKuliah->pertemuan_ke])">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Presensi</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $jadwalKuliah->kelasKuliah->mataKuliah->nama_mk }} — Pertemuan {{ $jadwalKuliah->pertemuan_ke }} — {{ $jadwalKuliah->tgl_pertemuan->format('d/m/Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge-aktif">{{ $presensis->count() }}/{{ $mahasiswas->count() }} Hadir</span>
                <a href="{{ route('dosen.presensi.export', $jadwalKuliah) }}">
                    <flux:button icon="arrow-down-tray" size="sm" class="btn-accent">Export CSV</flux:button>
                </a>
                <a href="{{ route('dosen.jadwal.index') }}" wire:navigate>
                    <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
                </a>
            </div>
        </div>

        <div class="card-unas overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-unas">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th class="text-center">Status</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswas as $i => $mhs)
                            @php $p = $presensis->get($mhs->id); @endphp
                            <tr>
                                <td class="px-3 py-2.5 sm:px-5 sm:py-3.5 text-slate-400 dark:text-slate-500 text-xs">{{ $i + 1 }}</td>
                                <td class="px-3 py-2.5 sm:px-5 sm:py-3.5 font-mono text-xs text-slate-600 dark:text-slate-400">{{ $mhs->nim }}</td>
                                <td class="px-3 py-2.5 sm:px-5 sm:py-3.5 font-medium text-slate-900 dark:text-white">{{ $mhs->nama_lengkap }}</td>
                                <td class="px-3 py-2.5 sm:px-5 sm:py-3.5 text-center">
                                    @if($p)
                                        @php
                                            $st = match($p->status) {
                                                'hadir' => 'badge-aktif',
                                                'izin' => 'badge-pending',
                                                'sakit' => 'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400',
                                                'alfa' => 'badge-ditolak',
                                                default => 'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-600',
                                            };
                                        @endphp
                                        <span class="{{ $st }}">
                                            @if($p->status === 'hadir') <flux:icon.check class="size-3" />
                                            @elseif($p->status === 'izin') <flux:icon.document-text class="size-3" />
                                            @elseif($p->status === 'sakit') <flux:icon.heart class="size-3" />
                                            @elseif($p->status === 'alfa') <flux:icon.x-mark class="size-3" />
                                            @endif
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    @else
                                        <span class="badge-ditolak"><flux:icon.x-mark class="size-3" /> Alfa</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5 sm:px-5 sm:py-3.5 text-xs text-slate-500 dark:text-slate-400 font-mono">{{ $p && $p->waktu_presensi ? $p->waktu_presensi->format('H:i d/m/Y') : '-' }}</td>
                                <td class="px-3 py-2.5 sm:px-5 sm:py-3.5 text-xs text-slate-500 dark:text-slate-400 italic max-w-xs truncate">{{ $p->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-600">Tidak ada mahasiswa terdaftar</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
