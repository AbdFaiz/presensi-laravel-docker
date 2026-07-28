<x-layouts::app :title="__('Presensi')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <flux:heading size="xl">Presensi</flux:heading>

        @if(session('success'))
            <flux:callout icon="check-circle" color="green">{{ session('success') }}</flux:callout>
        @endif
        @if(session('error'))
            <flux:callout icon="exclamation-circle" color="red">{{ session('error') }}</flux:callout>
        @endif

        <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800 p-4">
            <flux:heading size="sm">Sesi Aktif - Isi Presensi</flux:heading>
            <div class="mt-3 space-y-3">
                @forelse($jadwalAktif as $jadwal)
                    <div class="flex items-center justify-between rounded-lg border border-neutral-100 p-4 dark:border-neutral-600">
                        <div>
                            <div class="font-bold">{{ $jadwal->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</div>
                            <div class="text-sm text-zinc-500">Pertemuan {{ $jadwal->pertemuan_ke }} | {{ $jadwal->tgl_pertemuan->format('d/m/Y') }} | {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</div>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}">
                                @csrf
                                <input type="hidden" name="status" value="hadir" />
                                <flux:button size="xs" variant="primary" icon="check" as="submit">Hadir</flux:button>
                            </form>
                            <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}">
                                @csrf
                                <input type="hidden" name="status" value="izin" />
                                <flux:button size="xs" variant="subtle" icon="document-text" as="submit">Izin</flux:button>
                            </form>
                            <form method="POST" action="{{ route('mhs.presensi.submit', $jadwal) }}">
                                @csrf
                                <input type="hidden" name="status" value="sakit" />
                                <flux:button size="xs" variant="subtle" icon="heart" as="submit">Sakit</flux:button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-zinc-400">
                        Tidak ada sesi presensi aktif saat ini
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800 p-4">
            <flux:heading size="sm">Riwayat Presensi</flux:heading>
            <div class="mt-3 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-neutral-200 dark:border-neutral-700">
                        <tr>
                            <th class="px-4 py-3 font-medium">Mata Kuliah</th>
                            <th class="px-4 py-3 font-medium">Pertemuan</th>
                            <th class="px-4 py-3 font-medium">Tanggal</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Waktu Submit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($riwayat as $r)
                            <tr>
                                <td class="px-4 py-3">{{ $r->jadwalKuliah->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3">Pertemuan {{ $r->jadwalKuliah->pertemuan_ke ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $r->jadwalKuliah->tgl_pertemuan?->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($r->status === 'hadir')
                                        <flux:badge color="green">Hadir</flux:badge>
                                    @elseif($r->status === 'izin')
                                        <flux:badge color="yellow">Izin</flux:badge>
                                    @elseif($r->status === 'sakit')
                                        <flux:badge color="blue">Sakit</flux:badge>
                                    @else
                                        <flux:badge color="red">Alpha</flux:badge>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-zinc-500">{{ $r->waktu_presensi?->format('d/m/Y H:i') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-zinc-400">Belum ada riwayat presensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
