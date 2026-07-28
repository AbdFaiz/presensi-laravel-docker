<x-layouts::app :title="__('Admin Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <flux:heading size="xl">Selamat Datang, {{ auth()->user()->name }}</flux:heading>
            <flux:text class="mt-1">Panel Administrasi Sistem Presensi</flux:text>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Total Users</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ \App\Models\User::count() }}</div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Program Studi</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ \App\Models\ProgramStudi::count() }}</div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Mata Kuliah</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ \App\Models\MataKuliah::count() }}</div>
            </div>
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:text class="text-sm text-zinc-500">Kelas Aktif</flux:text>
                <div class="mt-2 text-3xl font-bold">{{ \App\Models\KelasKuliah::count() }}</div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:heading size="sm">KRS Menunggu Persetujuan</flux:heading>
                <div class="mt-4 space-y-2">
                    @php $pending = \App\Models\KrsDetail::where('status', 'pending')->with(['mahasiswa', 'kelasKuliah.mataKuliah'])->get(); @endphp
                    @forelse($pending as $krs)
                        <div class="flex items-center justify-between rounded-lg border border-neutral-100 p-3 dark:border-neutral-600">
                            <div>
                                <div class="font-medium">{{ $krs->mahasiswa->nama_lengkap ?? '-' }}</div>
                                <div class="text-sm text-zinc-500">{{ $krs->kelasKuliah->mataKuliah->nama_mk ?? '-' }} ({{ $krs->kelasKuliah->nama_kelas ?? '-' }})</div>
                            </div>
                            <flux:badge color="yellow">Pending</flux:badge>
                        </div>
                    @empty
                        <flux:text class="text-zinc-400">Tidak ada KRS pending</flux:text>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
                <flux:heading size="sm">Akses Cepat</flux:heading>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('admin.users.index') }}" class="block rounded-lg border border-neutral-100 p-3 hover:bg-zinc-50 dark:border-neutral-600 dark:hover:bg-zinc-700" wire:navigate>
                        <div class="font-medium">Kelola Users</div>
                        <div class="text-sm text-zinc-500">Manajemen akun admin, dosen, mahasiswa</div>
                    </a>
                    <a href="{{ route('admin.prodi.index') }}" class="block rounded-lg border border-neutral-100 p-3 hover:bg-zinc-50 dark:border-neutral-600 dark:hover:bg-zinc-700" wire:navigate>
                        <div class="font-medium">Program Studi</div>
                        <div class="text-sm text-zinc-500">Kelola data program studi</div>
                    </a>
                    <a href="{{ route('admin.mk.index') }}" class="block rounded-lg border border-neutral-100 p-3 hover:bg-zinc-50 dark:border-neutral-600 dark:hover:bg-zinc-700" wire:navigate>
                        <div class="font-medium">Mata Kuliah</div>
                        <div class="text-sm text-zinc-500">Kelola data mata kuliah</div>
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="block rounded-lg border border-neutral-100 p-3 hover:bg-zinc-50 dark:border-neutral-600 dark:hover:bg-zinc-700" wire:navigate>
                        <div class="font-medium">Kelas</div>
                        <div class="text-sm text-zinc-500">Kelola kelas dan pengampu</div>
                    </a>
                    <a href="{{ route('admin.krs.index') }}" class="block rounded-lg border border-neutral-100 p-3 hover:bg-zinc-50 dark:border-neutral-600 dark:hover:bg-zinc-700" wire:navigate>
                        <div class="font-medium">KRS</div>
                        <div class="text-sm text-zinc-500">Setujui atau tolak KRS mahasiswa</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
