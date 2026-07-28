<x-layouts::app :title="__('Mata Kuliah')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Mata Kuliah</flux:heading>
            <a href="{{ route('admin.mk.create') }}" wire:navigate>
                <flux:button icon="plus">Tambah Mata Kuliah</flux:button>
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
                            <th class="px-4 py-3 font-medium">SKS</th>
                            <th class="px-4 py-3 font-medium">Semester</th>
                            <th class="px-4 py-3 font-medium">Prodi</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($matkuls as $mk)
                            <tr>
                                <td class="px-4 py-3 font-mono font-bold">{{ $mk->kode_mk }}</td>
                                <td class="px-4 py-3">{{ $mk->nama_mk }}</td>
                                <td class="px-4 py-3">{{ $mk->sks }}</td>
                                <td class="px-4 py-3">{{ $mk->semester }}</td>
                                <td class="px-4 py-3">{{ $mk->programStudi->kode ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.mk.edit', $mk) }}" wire:navigate>
                                            <flux:button size="xs" variant="primary">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.mk.destroy', $mk) }}" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button size="xs" variant="danger" as="submit">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-400">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
