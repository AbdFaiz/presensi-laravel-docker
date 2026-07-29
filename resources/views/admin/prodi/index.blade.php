<x-layouts::app :title="__('Program Studi')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Program Studi</h1>
                <p class="mt-1 text-sm text-zinc-500">Kelola data program studi</p>
            </div>
            <a href="{{ route('admin.prodi.create') }}" wire:navigate>
                <flux:button icon="plus" class="!bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-sm">Tambah Prodi</flux:button>
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl border border-zinc-200/60 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="px-5 py-4 text-left font-medium text-zinc-500 w-24">Kode</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Nama Program Studi</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Deskripsi</th>
                            <th class="px-5 py-4 text-right font-medium text-zinc-500 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @forelse($prodis as $prodi)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/5 transition-colors">
                                <td class="px-5 py-4"><span class="font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $prodi->kode }}</span></td>
                                <td class="px-5 py-4 font-medium text-zinc-900 dark:text-white">{{ $prodi->nama }}</td>
                                <td class="px-5 py-4 text-zinc-500 max-w-xs truncate">{{ Str::limit($prodi->deskripsi, 60) }}</td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.prodi.edit', $prodi) }}" wire:navigate>
                                            <flux:button size="xs" variant="subtle" icon="pencil-square">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.prodi.destroy', $prodi) }}" onsubmit="return confirm('Yakin hapus?')" class="inline">
                                            @csrf @method('DELETE')
                                            <flux:button size="xs" variant="subtle" icon="trash" type="submit" class="text-red-500 hover:!text-red-600 hover:!bg-red-50 dark:hover:!bg-red-900/20">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-12 text-center text-sm text-zinc-400">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
