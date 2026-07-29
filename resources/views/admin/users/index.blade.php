<x-layouts::app :title="__('Kelola Users')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Users</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manajemen akun pengguna sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}" wire:navigate>
                <flux:button icon="plus" class="btn-accent">Tambah User</flux:button>
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card-unas overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-unas">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            @php
                                $roleBadge = match($user->role) {
                                    'admin' => 'badge-aktif',
                                    'dosen' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                                    'mahasiswa' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    default => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400',
                                };
                            @endphp
                            <tr>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 font-medium text-slate-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-600 font-mono text-xs dark:text-slate-400">{{ $user->username }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-slate-500 dark:text-slate-400">{{ $user->email }}</td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4">
                                    <span class="{{ $roleBadge }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="px-3 py-3 sm:px-5 sm:py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" wire:navigate>
                                            <flux:button size="xs" variant="subtle" icon="pencil-square">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus user ini?')" class="inline">
                                            @csrf @method('DELETE')
                                            <flux:button size="xs" variant="subtle" icon="trash" type="submit" class="text-rose-500 hover:!bg-rose-50 dark:hover:!bg-rose-950/30">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center text-sm text-slate-400 dark:text-slate-500">Belum ada data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
