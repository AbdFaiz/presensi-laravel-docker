<x-layouts::app :title="__('KRS')">
    <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Ambil Kelas (KRS)</h1>
            <p class="mt-1 text-sm text-zinc-500">Daftar atau lihat status kelas Anda</p>
        </div>

        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">{{ session('error') }}</div>
        @endif

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Kelas yang Saya Ambil</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Kelas</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Mata Kuliah</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Dosen</th>
                            <th class="px-4 py-3 text-center font-medium text-zinc-500">Status</th>
                            <th class="px-4 py-3 text-right font-medium text-zinc-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @forelse($krsSaya as $krs)
                            <tr>
                                <td class="px-4 py-3.5 font-bold text-zinc-900 dark:text-white">{{ $krs->kelasKuliah->nama_kelas ?? '-' }}</td>
                                <td class="px-4 py-3.5">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-zinc-600">{{ $krs->kelasKuliah->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-center">
                                    @php
                                        $sc = ['pending' => 'bg-amber-100 text-amber-700', 'aktif' => 'bg-emerald-100 text-emerald-700', 'ditolak' => 'bg-red-100 text-red-700', 'dibatalkan' => 'bg-zinc-100 text-zinc-600'];
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $sc[$krs->status] ?? 'bg-zinc-100 text-zinc-600' }}">{{ ucfirst($krs->status) }}</span>
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    @if($krs->status === 'pending')
                                        <form method="POST" action="{{ route('mhs.krs.batal', $krs) }}" class="inline">
                                            @csrf
                                            <flux:button size="xs" variant="subtle" icon="x-mark" type="submit" class="text-red-500 hover:!text-red-600">Batal</flux:button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-sm text-zinc-400">Belum ada kelas yang diambil</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-white">Kelas Tersedia</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Kelas</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Mata Kuliah</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-500">Dosen</th>
                            <th class="px-4 py-3 text-right font-medium text-zinc-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        @forelse($kelasTersedia as $kelas)
                            <tr>
                                <td class="px-4 py-3.5 font-bold text-zinc-900 dark:text-white">{{ $kelas->nama_kelas }}</td>
                                <td class="px-4 py-3.5">{{ $kelas->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-zinc-600">{{ $kelas->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-4 py-3.5 text-right">
                                    <form method="POST" action="{{ route('mhs.krs.ambil', $kelas) }}" class="inline">
                                        @csrf
                                        <flux:button size="xs" class="!bg-emerald-600 !text-white hover:!bg-emerald-700" icon="plus" as="submit">Ambil Kelas</flux:button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-sm text-zinc-400">Tidak ada kelas tersedia</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
