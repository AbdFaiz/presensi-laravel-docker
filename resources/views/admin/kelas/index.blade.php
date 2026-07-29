<x-layouts::app :title="__('Kelas Kuliah')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelas Kuliah</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola kelas, mata kuliah, dan dosen pengampu</p>
            </div>
            <a href="{{ route('admin.kelas.create') }}" wire:navigate>
                <flux:button icon="plus" class="btn-accent">Tambah Kelas</flux:button>
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
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen Pengampu</th>
                            <th>Tahun Akademik</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelases as $kelas)
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-bold text-slate-900 dark:text-white">{{ $kelas->nama_kelas }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400 font-medium">{{ $kelas->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400">{{ $kelas->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4"><span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">{{ $kelas->tahun_akademik }}</span></td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.kelas.edit', $kelas) }}" wire:navigate>
                                            <flux:button size="xs" variant="subtle" icon="pencil-square">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.kelas.destroy', $kelas) }}" onsubmit="return confirm('Yakin hapus?')" class="inline">
                                            @csrf @method('DELETE')
                                            <flux:button size="xs" variant="subtle" icon="trash" type="submit" class="text-rose-500 hover:!bg-rose-50 dark:hover:!bg-rose-950/30">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
