<x-layouts::app :title="__('Kelas Saya')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelas Saya</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Daftar kelas yang telah Anda ambil</p>
            </div>
            <a href="{{ route('mhs.krs.daftar') }}" wire:navigate>
                <flux:button icon="plus" class="btn-accent">Ambil Kelas Baru</flux:button>
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
                            <th class="text-center">Status</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($krsSaya as $krs)
                            @php
                                $badge = match($krs->status) {
                                    'pending' => 'badge-pending',
                                    'aktif' => 'badge-aktif',
                                    'ditolak' => 'badge-ditolak',
                                    'dibatalkan' => 'badge-dibatalkan',
                                    default => 'badge-pending',
                                };
                            @endphp
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-semibold text-slate-900 dark:text-white">{{ $krs->kelasKuliah->nama_kelas ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 dark:text-slate-400">{{ $krs->kelasKuliah->dosen->nama_lengkap ?? '-' }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-center">
                                    <span class="{{ $badge }}">
                                        @if($krs->status === 'pending') <flux:icon.clock class="size-3" />
                                        @elseif($krs->status === 'aktif') <flux:icon.check class="size-3" />
                                        @elseif($krs->status === 'ditolak') <flux:icon.x-mark class="size-3" />
                                        @endif
                                        {{ ucfirst($krs->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right">
                                    @if($krs->status === 'pending')
                                        <form method="POST" action="{{ route('mhs.krs.batal', $krs) }}" class="inline" onsubmit="return confirm('Batalkan pengajuan KRS ini?')">
                                            @csrf
                                            <flux:button size="xs" icon="x-mark" type="submit" class="text-rose-500 hover:!bg-rose-50 dark:hover:!bg-rose-950/30">Batal</flux:button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-600">Belum ada kelas yang diambil</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
