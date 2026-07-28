<x-layouts::app :title="__('KRS Management')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <flux:heading size="xl">KRS - Persetujuan Kelas</flux:heading>

        @if(session('success'))
            <flux:callout icon="check-circle" color="green">{{ session('success') }}</flux:callout>
        @endif

        <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-neutral-200 dark:border-neutral-700">
                        <tr>
                            <th class="px-4 py-3 font-medium">Mahasiswa</th>
                            <th class="px-4 py-3 font-medium">NIM</th>
                            <th class="px-4 py-3 font-medium">Kelas</th>
                            <th class="px-4 py-3 font-medium">Mata Kuliah</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($krs as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->mahasiswa->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3 font-mono">{{ $item->mahasiswa->nim ?? '-' }}</td>
                                <td class="px-4 py-3 font-bold">{{ $item->kelasKuliah->nama_kelas ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($item->status === 'pending')
                                        <flux:badge color="yellow">Pending</flux:badge>
                                    @elseif($item->status === 'aktif')
                                        <flux:badge color="green">Aktif</flux:badge>
                                    @elseif($item->status === 'ditolak')
                                        <flux:badge color="red">Ditolak</flux:badge>
                                    @else
                                        <flux:badge color="gray">Dibatalkan</flux:badge>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($item->status === 'pending')
                                        <div class="flex gap-2">
                                            <form method="POST" action="{{ route('admin.krs.approve', $item) }}">
                                                @csrf
                                                <flux:button size="xs" variant="primary" icon="check" as="submit">Approve</flux:button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.krs.reject', $item) }}">
                                                @csrf
                                                <flux:button size="xs" variant="danger" icon="x-mark" as="submit">Reject</flux:button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-zinc-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-400">Belum ada data KRS</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
