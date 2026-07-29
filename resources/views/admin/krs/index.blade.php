<x-layouts::app :title="__('KRS Management')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">KRS</h1>
            <p class="mt-1 text-sm text-zinc-500">Persetujuan Kartu Rencana Studi mahasiswa</p>
        </div>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl border border-zinc-200/60 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Mahasiswa</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">NIM</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Kelas</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Mata Kuliah</th>
                            <th class="px-5 py-4 text-center font-medium text-zinc-500">Status</th>
                            <th class="px-5 py-4 text-right font-medium text-zinc-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @forelse($krs as $item)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/5 transition-colors">
                                <td class="px-5 py-4 font-medium text-zinc-900 dark:text-white">{{ $item->mahasiswa->nama_lengkap ?? '-' }}</td>
                                <td class="px-5 py-4 font-mono text-sm text-zinc-600">{{ $item->mahasiswa->nim ?? '-' }}</td>
                                <td class="px-5 py-4 font-medium">{{ $item->kelasKuliah->nama_kelas ?? '-' }}</td>
                                <td class="px-5 py-4 text-zinc-600">{{ $item->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-5 py-4 text-center">
                                    @php
                                        $statusColors = ['pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400', 'aktif' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400', 'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400', 'dibatalkan' => 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'];
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium uppercase tracking-wider {{ $statusColors[$item->status] ?? 'bg-zinc-100 text-zinc-600' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    @if($item->status === 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            <form method="POST" action="{{ route('admin.krs.approve', $item) }}" class="inline">
                                                @csrf
                                                <flux:button size="xs" class="!bg-emerald-600 !text-white hover:!bg-emerald-700" icon="check" as="submit">Approve</flux:button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.krs.reject', $item) }}" class="inline">
                                                @csrf
                                                <flux:button size="xs" variant="subtle" icon="x-mark" type="submit" class="text-red-500 hover:!text-red-600 hover:!bg-red-50 dark:hover:!bg-red-900/20">Reject</flux:button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-zinc-400">&mdash;</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-zinc-400">Belum ada data KRS</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
