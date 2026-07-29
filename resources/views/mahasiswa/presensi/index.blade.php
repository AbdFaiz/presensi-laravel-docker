<x-layouts::app :title="__('Presensi')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Presensi</h1>
            <p class="mt-1 text-sm text-zinc-500">Isi kehadiran perkuliahan</p>
        </div>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">{{ session('error') }}</div>
        @endif

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Sesi Aktif</h2>
            <div class="mt-4 grid gap-3">
                @forelse($jadwalAktif as $jadwal)
                    <div class="group flex items-center justify-between rounded-xl border border-emerald-100 bg-emerald-50/50 p-4 dark:border-emerald-900/30 dark:bg-emerald-900/10">
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $jadwal->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</p>
                            <p class="mt-0.5 text-xs text-zinc-500">Pertemuan {{ $jadwal->pertemuan_ke }} · {{ $jadwal->tgl_pertemuan->format('d/m/Y') }} · {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                            <p class="text-xs text-zinc-400">{{ $jadwal->kelasKuliah->nama_kelas }}</p>
                        </div>
                        <div class="flex gap-2 shrink-0">
                            <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="hadir" />
                                <flux:button icon="check" size="sm" class="!bg-emerald-600 !text-white hover:!bg-emerald-700" as="submit">Hadir</flux:button>
                            </form>
                            <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="izin" />
                                <flux:button icon="document-text" size="sm" variant="subtle" as="submit">Izin</flux:button>
                            </form>
                            <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="sakit" />
                                <flux:button icon="heart" size="sm" variant="subtle" as="submit">Sakit</flux:button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-sm text-zinc-400">
                        <flux:icon.inbox class="mx-auto size-8 text-zinc-300 dark:text-zinc-600" />
                        <p class="mt-2">Tidak ada sesi presensi aktif saat ini</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Riwayat Presensi</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Mata Kuliah</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Pertemuan</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Tanggal</th>
                            <th class="px-4 py-3 text-center font-medium text-zinc-500">Status</th>
                            <th class="px-4 py-3 text-right font-medium text-zinc-500">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @forelse($riwayat as $r)
                            <tr>
                                <td class="px-4 py-3.5 font-medium text-zinc-900 dark:text-white">{{ $r->jadwalKuliah->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-zinc-600">Pertemuan {{ $r->jadwalKuliah->pertemuan_ke ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-zinc-600">{{ $r->jadwalKuliah->tgl_pertemuan?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-center">
                                    @php
                                        $sc2 = ['hadir' => 'bg-emerald-100 text-emerald-700', 'izin' => 'bg-amber-100 text-amber-700', 'sakit' => 'bg-blue-100 text-blue-700', 'alfa' => 'bg-red-100 text-red-700'];
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $sc2[$r->status] ?? 'bg-zinc-100 text-zinc-600' }}">{{ ucfirst($r->status) }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-right text-xs text-zinc-400 font-mono">{{ $r->waktu_presensi?->format('H:i d/m/Y') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-sm text-zinc-400">Belum ada riwayat presensi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
