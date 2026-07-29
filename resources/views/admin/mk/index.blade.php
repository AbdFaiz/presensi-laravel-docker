<x-layouts::app :title="__('Mata Kuliah')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Mata Kuliah</h1>
                <p class="mt-1 text-sm text-zinc-500">Kelola data mata kuliah per program studi</p>
            </div>
            <a href="{{ route('admin.mk.create') }}" wire:navigate>
                <flux:button icon="plus" class="!bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-sm">Tambah Mata Kuliah</flux:button>
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
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Kode</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500">Nama Mata Kuliah</th>
                            <th class="px-5 py-4 text-center font-medium text-zinc-500 w-16">SKS</th>
                            <th class="px-5 py-4 text-center font-medium text-zinc-500 w-20">Semester</th>
                            <th class="px-5 py-4 text-left font-medium text-zinc-500 w-24">Prodi</th>
                            <th class="px-5 py-4 text-right font-medium text-zinc-500 w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @forelse($matkuls as $mk)
                            <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/5 transition-colors">
                                <td class="px-5 py-4 font-mono font-bold text-emerald-600 dark:text-emerald-400">{{ $mk->kode_mk }}</td>
                                <td class="px-5 py-4 font-medium text-zinc-900 dark:text-white">{{ $mk->nama_mk }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center justify-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium dark:bg-zinc-800">{{ $mk->sks }}</span>
                                </td>
                                <td class="px-5 py-4 text-center text-zinc-600">{{ $mk->semester }}</td>
                                <td class="px-5 py-4"><span class="text-xs font-medium text-zinc-500">{{ $mk->programStudi->kode ?? '-' }}</span></td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.mk.edit', $mk) }}" wire:navigate>
                                            <flux:button size="xs" variant="subtle" icon="pencil-square">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.mk.destroy', $mk) }}" onsubmit="return confirm('Yakin hapus?')" class="inline">
                                            @csrf @method('DELETE')
                                            <flux:button size="xs" variant="subtle" icon="trash" type="submit" class="text-red-500 hover:!text-red-600 hover:!bg-red-50 dark:hover:!bg-red-900/20">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-zinc-400">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
