<x-layouts::app :title="__('KRS Saya')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <flux:heading size="xl">KRS Saya</flux:heading>

        @if(session('success'))
            <flux:callout icon="check-circle" color="green">{{ session('success') }}</flux:callout>
        @endif
        @if(session('error'))
            <flux:callout icon="exclamation-circle" color="red">{{ session('error') }}</flux:callout>
        @endif

        <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800 p-4">
            <flux:heading size="sm">Kelas yang Saya Ambil</flux:heading>
            <div class="mt-3 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-neutral-200 dark:border-neutral-700">
                        <tr>
                            <th class="px-4 py-3 font-medium">Kelas</th>
                            <th class="px-4 py-3 font-medium">Mata Kuliah</th>
                            <th class="px-4 py-3 font-medium">Dosen</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($krsSaya as $krs)
                            <tr>
                                <td class="px-4 py-3 font-bold">{{ $krs->kelasKuliah->nama_kelas ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $krs->kelasKuliah->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($krs->status === 'pending')
                                        <flux:badge color="yellow">Pending</flux:badge>
                                    @elseif($krs->status === 'aktif')
                                        <flux:badge color="green">Aktif</flux:badge>
                                    @elseif($krs->status === 'ditolak')
                                        <flux:badge color="red">Ditolak</flux:badge>
                                    @else
                                        <flux:badge color="gray">Dibatalkan</flux:badge>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($krs->status === 'pending')
                                        <form method="POST" action="{{ route('mhs.krs.batal', $krs) }}">
                                            @csrf
                                            <flux:button size="xs" variant="danger" as="submit">Batal</flux:button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-zinc-400">Belum ada kelas yang diambil</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-zinc-800 p-4">
            <flux:heading size="sm">Kelas Tersedia</flux:heading>
            <div class="mt-3 overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-neutral-200 dark:border-neutral-700">
                        <tr>
                            <th class="px-4 py-3 font-medium">Kelas</th>
                            <th class="px-4 py-3 font-medium">Mata Kuliah</th>
                            <th class="px-4 py-3 font-medium">Dosen</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($kelasTersedia as $kelas)
                            <tr>
                                <td class="px-4 py-3 font-bold">{{ $kelas->nama_kelas }}</td>
                                <td class="px-4 py-3">{{ $kelas->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $kelas->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('mhs.krs.ambil', $kelas) }}">
                                        @csrf
                                        <flux:button size="xs" variant="primary" icon="plus" as="submit">Ambil Kelas</flux:button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-zinc-400">Tidak ada kelas tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
