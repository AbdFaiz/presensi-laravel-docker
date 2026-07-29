<x-layouts::app :title="__('KRS Management')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">KRS</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Persetujuan Kartu Rencana Studi mahasiswa</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card-unas overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-unas">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($krs as $item)
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-medium text-slate-900 dark:text-white">{{ $item->mahasiswa->nama_lengkap ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-mono text-xs text-slate-600 dark:text-slate-400">{{ $item->mahasiswa->nim ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-medium text-slate-900 dark:text-white">{{ $item->kelasKuliah->nama_kelas ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400 font-medium">{{ $item->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-center">
                                    @php
                                        $badge = match($item->status) {
                                            'pending' => 'badge-pending',
                                            'aktif' => 'badge-aktif',
                                            'ditolak' => 'badge-ditolak',
                                            'dibatalkan' => 'badge-dibatalkan',
                                            default => 'badge-pending',
                                        };
                                    @endphp
                                    <span class="{{ $badge }}">
                                        @if($item->status === 'pending') <flux:icon.clock class="size-3" />
                                        @elseif($item->status === 'aktif') <flux:icon.check class="size-3" />
                                        @elseif($item->status === 'ditolak') <flux:icon.x-mark class="size-3" />
                                        @endif
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right">
                                    @if($item->status === 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            <form method="POST" action="{{ route('admin.krs.approve', $item) }}" class="inline" onsubmit="return confirm('Setujui KRS ini?')">
                                                @csrf
                                                <flux:button size="xs" class="btn-primary" icon="check" type="submit">Approve</flux:button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.krs.reject', $item) }}" class="inline" onsubmit="return confirm('Tolak KRS ini?')">
                                                @csrf
                                                <flux:button size="xs" class="!bg-rose-500 !text-white hover:!bg-rose-600" icon="x-mark" type="submit">Reject</flux:button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 dark:text-slate-500">&mdash;</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-500">Belum ada data KRS</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
