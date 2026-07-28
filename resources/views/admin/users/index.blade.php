<x-layouts::app :title="__('Kelola Users')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Kelola Users</flux:heading>
            <a href="{{ route('admin.users.create') }}" wire:navigate>
                <flux:button icon="plus">Tambah User</flux:button>
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
                            <th class="px-4 py-3 font-medium">Nama</th>
                            <th class="px-4 py-3 font-medium">Username</th>
                            <th class="px-4 py-3 font-medium">Email</th>
                            <th class="px-4 py-3 font-medium">Role</th>
                            <th class="px-4 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-700">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->username }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <flux:badge color="{{ $user->role === 'admin' ? 'red' : ($user->role === 'dosen' ? 'blue' : 'green') }}">
                                        {{ ucfirst($user->role) }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" wire:navigate>
                                            <flux:button size="xs" variant="primary">Edit</flux:button>
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button size="xs" variant="danger" as="submit">Hapus</flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-zinc-400">Belum ada data user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>
