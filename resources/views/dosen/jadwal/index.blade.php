<x-layouts::app :title="__('Jadwal Pertemuan')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Jadwal Pertemuan</flux:heading>
            <a href="{{ route('dosen.jadwal.create') }}" wire:navigate>
                <flux:button icon="plus">Tambah Pertemuan</flux:button>
            </a>
        </div>

        @if(session('success'))
            <flux:callout icon="check-circle" color="green">{{ session('success') }}</flux:callout>
        @endif

        <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-neutral-200 dark:border-neutral-700">
                        <tr>
                            <th class="px-4 py-3 font-medium">Pertemuan</th>
                            <th class="px-4 py-3 font-medium">Mata Kuliah</th>
                            <th class="px-4 py-3 font-medium">Tanggal</th>
                            <th class="px-4 py-3 font-medium">Jam</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($jadwals as $jadwal)
                            <tr>
                                <td class="px-4 py-3 font-bold">Pertemuan {{ $jadwal->pertemuan_ke }}</td>
                                <td class="px-4 py-3">{{ $jadwal->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $jadwal->tgl_pertemuan->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                                <td class="px-4 py-3">
                                    @if($jadwal->status_sesi === 'dibuka')
                                        <flux:badge color="green">Dibuka</flux:badge>
                                    @else
                                        <flux:badge color="gray">Ditutup</flux:badge>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('dosen.jadwal.toggle', $jadwal) }}">
                                        @csrf
                                        @method('PUT')
                                        @if($jadwal->status_sesi === 'dibuka')
                                            <flux:button size="xs" variant="danger" icon="stop" as="submit">Tutup Sesi</flux:button>
                                        @else
                                            <flux:button size="xs" variant="primary" icon="play" as="submit">Buka Sesi</flux:button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-400">Belum ada jadwal pertemuan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
