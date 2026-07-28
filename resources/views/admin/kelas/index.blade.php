<x-layouts::app :title="__('Kelas Kuliah')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Kelas Kuliah</flux:heading>
            <a href="{{ route('admin.kelas.create') }}" wire:navigate>
                <flux:button icon="plus">Tambah Kelas</flux:button>
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
                            <th class="px-4 py-3 font-medium">Nama Kelas</th>
                            <th class="px-4 py-3 font-medium">Mata Kuliah</th>
                            <th class="px-4 py-3 font-medium">Dosen</th>
                            <th class="px-4 py-3 font-medium">Tahun Akademik</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($kelases as $kelas)
                            <tr>
                                <td class="px-4 py-3 font-bold">{{ $kelas->nama_kelas }}</td>
                                <td class="px-4 py-3">{{ $kelas->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $kelas->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $kelas->tahun_akademik }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.kelas.edit', $kelas) }}" wire:navigate>
                                            <flux:button size="xs" variant="primary">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.kelas.destroy', $kelas) }}" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button size="xs" variant="danger" as="submit">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-zinc-400">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
