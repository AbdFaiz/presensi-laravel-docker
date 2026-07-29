<x-layouts::app :title="__('Daftar Kelas')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Kelas Baru</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Pilih kelas yang tersedia untuk diambil</p>
            </div>
            <a href="{{ route('mhs.krs.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="card-unas overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-unas">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelasTersedia as $kelas)
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-semibold text-slate-900 dark:text-white">{{ $kelas->nama_kelas }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400">{{ $kelas->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400">{{ $kelas->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right">
                                    <form method="POST" action="{{ route('mhs.krs.ambil', $kelas) }}" class="inline" onsubmit="return confirm('Ambil kelas {{ $kelas->nama_kelas }}?')">
                                        @csrf
                                        <flux:button size="xs" icon="plus" type="submit" class="btn-primary">Ambil</flux:button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-600">Tidak ada kelas tersedia</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
