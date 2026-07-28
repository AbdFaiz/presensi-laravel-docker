<x-layouts::app :title="__('Program Studi')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Program Studi</flux:heading>
            <a href="{{ route('admin.prodi.create') }}" wire:navigate>
                <flux:button icon="plus">Tambah Prodi</flux:button>
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
                            <th class="px-4 py-3 font-medium">Kode</th>
                            <th class="px-4 py-3 font-medium">Nama</th>
                            <th class="px-4 py-3 font-medium">Deskripsi</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($prodis as $prodi)
                            <tr>
                                <td class="px-4 py-3 font-mono font-bold">{{ $prodi->kode }}</td>
                                <td class="px-4 py-3">{{ $prodi->nama }}</td>
                                <td class="px-4 py-3 text-zinc-500">{{ Str::limit($prodi->deskripsi, 50) }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.prodi.edit', $prodi) }}" wire:navigate>
                                            <flux:button size="xs" variant="primary">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.prodi.destroy', $prodi) }}" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button size="xs" variant="danger" as="submit">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-zinc-400">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
