<x-layouts::app :title="__('Edit User')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Edit User: {{ $user->name }}</flux:heading>
            <a href="{{ route('admin.users.index') }}" wire:navigate>
                <flux:button variant="subtle">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <flux:input name="name" label="Nama" :value="old('name', $user->name)" required />
                <flux:input name="username" label="Username (NIM/NIP)" :value="old('username', $user->username)" required />
                <flux:input name="email" label="Email" type="email" :value="old('email', $user->email)" required />
                <flux:select name="role" label="Role" required>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ $user->role === 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ $user->role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </flux:select>

                @if($errors->any())
                    <div class="text-sm text-red-500">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <flux:button type="submit" icon="check">Update</flux:button>
            </form>
        </div>
    </div>
</x-layouts::app>
