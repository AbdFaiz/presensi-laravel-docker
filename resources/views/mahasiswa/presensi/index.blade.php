<x-layouts::app :title="__('Presensi')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Presensi</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Isi kehadiran perkuliahan</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="card-unas">
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                        <flux:icon.play class="size-5" />
                    </span>
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Sesi Aktif</h2>
                        <p class="text-xs text-slate-500">{{ $jadwalAktif->count() }} sesi dibuka</p>
                    </div>
                </div>
            </div>

            @if($jadwalAktif->isNotEmpty())
                <div class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach($jadwalAktif as $jadwal)
                        @php $sudah = $sudahPresensi[$jadwal->id] ?? null; @endphp
                        <div class="p-5 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $jadwal->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</p>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                                        <span class="inline-flex items-center gap-1"><flux:icon.calendar-days class="size-3.5" /> {{ $jadwal->tgl_pertemuan->format('d/m/Y') }}</span>
                                        <span class="inline-flex items-center gap-1"><flux:icon.clock class="size-3.5" /> {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</span>
                                        <span class="inline-flex items-center gap-1"><flux:icon.users class="size-3.5" /> {{ $jadwal->kelasKuliah->nama_kelas }}</span>
                                        <span class="text-slate-600 dark:text-slate-400 font-medium">Pertemuan #{{ $jadwal->pertemuan_ke }}</span>
                                    </div>
                                </div>

                                @if($sudah)
                                    @php
                                        $stt = match($sudah) {
                                            'hadir' => 'badge-aktif',
                                            'izin' => 'badge-pending',
                                            'sakit' => 'inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400',
                                            default => 'inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold bg-slate-100 text-slate-600',
                                        };
                                    @endphp
                                    <span class="{{ $stt }}">
                                        @if($sudah === 'hadir') <flux:icon.check class="size-3.5" />
                                        @elseif($sudah === 'izin') <flux:icon.document-text class="size-3.5" />
                                        @elseif($sudah === 'sakit') <flux:icon.heart class="size-3.5" />
                                        @endif
                                        {{ ucfirst($sudah) }}
                                    </span>
                                @else
                                    <div class="flex gap-2 shrink-0">
                                        <flux:modal.trigger name="presensi-hadir-{{ $jadwal->id }}">
                                            <flux:button icon="check" size="sm" class="btn-primary">Hadir</flux:button>
                                        </flux:modal.trigger>
                                        <flux:modal.trigger name="presensi-izin-{{ $jadwal->id }}">
                                            <flux:button icon="document-text" size="sm" variant="subtle" class="text-amber-600 hover:!bg-amber-50 dark:hover:!bg-amber-950/30">Izin</flux:button>
                                        </flux:modal.trigger>
                                        <flux:modal.trigger name="presensi-sakit-{{ $jadwal->id }}">
                                            <flux:button icon="heart" size="sm" variant="subtle" class="text-sky-600 hover:!bg-sky-50 dark:hover:!bg-sky-950/30">Sakit</flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                @endif
                            </div>

                            @if(!$sudah)
                            <flux:modal name="presensi-hadir-{{ $jadwal->id }}" class="max-w-sm">
                                <div class="space-y-5 p-1">
                                    <div class="text-center">
                                        <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-blue-50 dark:bg-slate-800/50"><flux:icon.check class="size-7 text-blue-600 dark:text-blue-400" /></span>
                                        <flux:heading class="mt-3">Presensi Hadir</flux:heading>
                                        <flux:subheading>{{ $jadwal->kelasKuliah->mataKuliah->nama_mk }} — Pertemuan {{ $jadwal->pertemuan_ke }}</flux:subheading>
                                    </div>
                                    <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="hadir" />
                                        <flux:textarea name="keterangan" label="Keterangan (opsional)" placeholder="Catatan jika perlu" rows="2" />
                                        <div class="mt-5 flex gap-3 justify-end">
                                            <flux:modal.close><flux:button variant="subtle">Batal</flux:button></flux:modal.close>
                                            <flux:button type="submit" class="btn-primary">Konfirmasi Hadir</flux:button>
                                        </div>
                                    </form>
                                </div>
                            </flux:modal>

                            <flux:modal name="presensi-izin-{{ $jadwal->id }}" class="max-w-sm">
                                <div class="space-y-5 p-1">
                                    <div class="text-center">
                                        <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-amber-50 dark:bg-amber-900/30"><flux:icon.document-text class="size-7 text-amber-600 dark:text-amber-400" /></span>
                                        <flux:heading class="mt-3">Presensi Izin</flux:heading>
                                        <flux:subheading>{{ $jadwal->kelasKuliah->mataKuliah->nama_mk }} — Pertemuan {{ $jadwal->pertemuan_ke }}</flux:subheading>
                                    </div>
                                    <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="izin" />
                                        <flux:textarea name="keterangan" label="Alasan Izin" placeholder="Tuliskan alasan izin..." rows="3" required />
                                        <div class="mt-5 flex gap-3 justify-end">
                                            <flux:modal.close><flux:button variant="subtle">Batal</flux:button></flux:modal.close>
                                            <flux:button type="submit" class="btn-accent">Kirim Izin</flux:button>
                                        </div>
                                    </form>
                                </div>
                            </flux:modal>

                            <flux:modal name="presensi-sakit-{{ $jadwal->id }}" class="max-w-sm">
                                <div class="space-y-5 p-1">
                                    <div class="text-center">
                                        <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-sky-50 dark:bg-sky-900/30"><flux:icon.heart class="size-7 text-sky-600 dark:text-sky-400" /></span>
                                        <flux:heading class="mt-3">Presensi Sakit</flux:heading>
                                        <flux:subheading>{{ $jadwal->kelasKuliah->mataKuliah->nama_mk }} — Pertemuan {{ $jadwal->pertemuan_ke }}</flux:subheading>
                                    </div>
                                    <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="sakit" />
                                        <flux:textarea name="keterangan" label="Keterangan Sakit" placeholder="Tuliskan keterangan..." rows="3" required />
                                        <div class="mt-5 flex gap-3 justify-end">
                                            <flux:modal.close><flux:button variant="subtle">Batal</flux:button></flux:modal.close>
                                            <flux:button type="submit" class="!bg-sky-600 !text-white hover:!bg-sky-700">Kirim Sakit</flux:button>
                                        </div>
                                    </form>
                                </div>
                            </flux:modal>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-16 text-center">
                    <span class="mx-auto flex size-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800/50">
                        <flux:icon.inbox class="size-8 text-slate-300 dark:text-slate-600" />
                    </span>
                    <p class="mt-4 font-medium text-slate-900 dark:text-white">Tidak ada sesi aktif</p>
                    <p class="mt-1 text-sm text-slate-500">Belum ada sesi presensi yang dibuka oleh dosen</p>
                </div>
            @endif
        </div>

        <div class="card-unas overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                        <flux:icon.clock class="size-5" />
                    </span>
                    <div>
                        <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Riwayat Presensi</h2>
                        <p class="text-xs text-slate-500">{{ $riwayat->count() }} catatan kehadiran</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table-unas">
                    <thead>
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Pertemuan</th>
                            <th>Tanggal</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-medium text-slate-900 dark:text-white">{{ $r->jadwalKuliah->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400 font-mono">#{{ $r->jadwalKuliah->pertemuan_ke ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400">{{ $r->jadwalKuliah->tgl_pertemuan?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-center">
                                    @php
                                        $sc2 = ['hadir' => 'badge-aktif', 'izin' => 'badge-pending', 'sakit' => 'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400', 'alfa' => 'badge-ditolak'];
                                    @endphp
                                    <span class="{{ $sc2[$r->status] ?? 'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-600' }}">
                                        @if($r->status === 'hadir') <flux:icon.check class="size-3" />
                                        @elseif($r->status === 'izin') <flux:icon.document-text class="size-3" />
                                        @elseif($r->status === 'sakit') <flux:icon.heart class="size-3" />
                                        @elseif($r->status === 'alfa') <flux:icon.x-mark class="size-3" />
                                        @endif
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right text-xs text-slate-400 font-mono dark:text-slate-600">{{ $r->waktu_presensi?->format('H:i d/m/Y') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-600">Belum ada riwayat presensi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
