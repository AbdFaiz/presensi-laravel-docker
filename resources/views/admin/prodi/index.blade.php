<x-layouts::app :title="__('Program Studi')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Program Studi</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola data program studi</p>
            </div>
            <a href="{{ route('admin.prodi.create') }}" wire:navigate>
                <flux:button icon="plus" class="btn-accent">Tambah Prodi</flux:button>
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
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prodis as $prodi)
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4"><span class="inline-flex font-mono font-bold text-slate-700 bg-slate-100 rounded-md px-2 py-1 text-xs dark:bg-slate-800 dark:text-slate-300">{{ $prodi->kode }}</span></td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-medium text-slate-900 dark:text-white">{{ $prodi->nama }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-500 dark:text-slate-400 max-w-xs truncate">{{ Str::limit($prodi->deskripsi, 60) }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.prodi.edit', $prodi) }}" wire:navigate>
                                            <flux:button size="xs" variant="subtle" icon="pencil-square">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.prodi.destroy', $prodi) }}" onsubmit="return confirm('Yakin hapus?')" class="inline">
                                            @csrf @method('DELETE')
                                            <flux:button size="xs" variant="subtle" icon="trash" type="submit" class="text-rose-500 hover:!bg-rose-50 dark:hover:!bg-rose-950/30">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
